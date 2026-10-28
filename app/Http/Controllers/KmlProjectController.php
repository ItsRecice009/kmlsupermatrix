<?php

namespace App\Http\Controllers;

use App\Models\KmlProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KmlProjectController extends Controller
{
    /**
     * Tentukan foreign key pemilik proyek berdasarkan akun yang login.
     */
    private function ownerIds(): array
    {
        $identifier = Auth::check() ? (string) Auth::user()->getAuthIdentifier() : '';

        return [
            'pegawai_id' => str_starts_with($identifier, 'pegawai_') ? (int) substr($identifier, 8) : null,
            'admin_id' => str_starts_with($identifier, 'admin_') ? (int) substr($identifier, 6) : null,
        ];
    }

    /**
     * Get all KML projects and summary statistics
     */
    public function index()
    {
        $projects = KmlProject::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'stats' => [
                'total_projects' => $projects->count(),
            ],
            'data' => $projects
        ]);
    }

    /**
     * Store new KML project
     */
    public function store(Request $request)
    {
        // Case 1: Uploading a .kml file
        if ($request->hasFile('kml_file')) {
            $request->validate([
                'kml_file' => 'required|file',
                'nama_project' => 'required|string|max:255',
                'area' => 'required|string|max:255',
                'tanggal_survei' => 'required|date',
            ], [
                'kml_file.required' => 'Kolom File KML wajib diisi!',
                'nama_project.required' => 'Kolom Nama Proyek wajib diisi!',
                'area.required' => 'Kolom Area / Witel wajib diisi!',
                'tanggal_survei.required' => 'Kolom Tanggal Survei wajib diisi!',
            ]);

            $file = $request->file('kml_file');
            $originalName = $file->getClientOriginalName();
            $projectName = $request->nama_project 
                ?: pathinfo($originalName, PATHINFO_FILENAME);
            $content = file_get_contents($file->getRealPath());

            // Deteksi duplikasi berkas KML yang sama di database
            $existingFile = KmlProject::whereRaw('LOWER(file_name) = ?', [strtolower($originalName)])->first();
            if ($existingFile) {
                return response()->json([
                    'success' => false,
                    'message' => "Data KML \"{$originalName}\" sudah terdaftar di database!"
                ], 422);
            }

            // Deteksi duplikasi nama proyek KML yang sama di database
            $existingProject = KmlProject::whereRaw('LOWER(nama_project) = ?', [strtolower($projectName)])->first();
            if ($existingProject) {
                return response()->json([
                    'success' => false,
                    'message' => "Data KML \"{$projectName}\" sudah terdaftar di database!"
                ], 422);
            }

            // Simpan berkas fisik ke storage disk tanpa memicu symfony/mime fileinfo guesser
            $safeFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
            if (!str_ends_with(strtolower($safeFileName), '.kml') && !str_ends_with(strtolower($safeFileName), '.xml')) {
                $safeFileName .= '.kml';
            }
            $storedPath = 'kml/' . $safeFileName;
            $targetDir = storage_path('app/kml');
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0755, true);
            }
            file_put_contents(storage_path('app/' . $storedPath), $content);

            // Parser hanya untuk membaca preview placemark / koordinat peta
            $parsedData = $this->parseKmlContent($content);

            $project = KmlProject::create([
                ...$this->ownerIds(),
                'nama_project' => $projectName,
                'area' => $request->area ?: 'Witel Regional',
                'tanggal_survei' => $request->tanggal_survei ?: now()->toDateString(),
                'file_name' => $originalName,
                'file_path' => $storedPath,
                'raw_kml' => $content, // 100% isi file asli
                'data_json' => json_encode($parsedData['placemarks']),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Berkas KML berhasil disimpan!',
                'data' => $project
            ], 201);
        }

        // Case 2: JSON payload from frontend workspace / Leaflet map
        $request->validate([
            'nama_project' => 'required|string|max:255',
            'area' => 'nullable|string|max:255',
            'tanggal_survei' => 'nullable|date',
            'file_name' => 'nullable|string|max:255',
            'placemarks' => 'nullable|array',
            'cables' => 'nullable|array',
        ]);

        $placemarksData = $request->input('placemarks', []);
        $cablesData = $request->input('cables', []);

        $project = KmlProject::create([
            ...$this->ownerIds(),
            'nama_project' => $request->nama_project,
            'area' => $request->area ?: 'Witel Area',
            'tanggal_survei' => $request->tanggal_survei ?: now()->toDateString(),
            'file_name' => $request->file_name ?: ($request->nama_project . '.kml'),
            'data_json' => json_encode($placemarksData),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data KML berhasil disimpan ke database!',
            'data' => $project
        ], 201);
    }

    /**
     * Show single KML project detail
     */
    public function show($id)
    {
        $project = KmlProject::findOrFail($id);
        
        $projectArray = $project->toArray();
        $projectArray['placemarks'] = json_decode($project->data_json, true) ?: [];

        return response()->json([
            'success' => true,
            'data' => $projectArray
        ]);
    }

    /**
     * Update KML project metadata
     */
    public function update(Request $request, $id)
    {
        $project = KmlProject::findOrFail($id);

        $request->validate([
            'nama_project' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'tanggal_survei' => 'required|date',
            'kml_file' => 'nullable|file',
        ], [
            'nama_project.required' => 'Kolom Nama Proyek wajib diisi!',
            'area.required' => 'Kolom Area / Witel wajib diisi!',
            'tanggal_survei.required' => 'Kolom Tanggal Survei wajib diisi!',
        ]);

        // Deteksi duplikasi nama proyek KML pada entri lain
        $existingProject = KmlProject::where('id', '!=', $id)
            ->whereRaw('LOWER(nama_project) = ?', [strtolower($request->nama_project)])
            ->first();
        if ($existingProject) {
            return response()->json([
                'success' => false,
                'message' => "Data KML \"{$request->nama_project}\" sudah terdaftar di database!"
            ], 422);
        }

        $updateData = [
            'nama_project' => $request->nama_project,
            'area' => $request->area ?: $project->area,
            'tanggal_survei' => $request->tanggal_survei ?: $project->tanggal_survei,
        ];

        // Jika user memilih file KML baru untuk menggantikan berkas lama
        if ($request->hasFile('kml_file')) {
            $file = $request->file('kml_file');
            $originalName = $file->getClientOriginalName();

            // Deteksi duplikasi berkas KML pada entri lain
            $existingFile = KmlProject::where('id', '!=', $id)
                ->whereRaw('LOWER(file_name) = ?', [strtolower($originalName)])
                ->first();
            if ($existingFile) {
                return response()->json([
                    'success' => false,
                    'message' => "Data KML \"{$originalName}\" sudah terdaftar di database!"
                ], 422);
            }

            $content = file_get_contents($file->getRealPath());

            // Hapus berkas fisik lama dari storage jika ada
            if (!empty($project->file_path)) {
                $oldFullPath = storage_path('app/' . $project->file_path);
                if (file_exists($oldFullPath)) {
                    @unlink($oldFullPath);
                }
            }

            // Simpan berkas fisik baru ke storage
            $safeFileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
            if (!str_ends_with(strtolower($safeFileName), '.kml') && !str_ends_with(strtolower($safeFileName), '.xml')) {
                $safeFileName .= '.kml';
            }
            $storedPath = 'kml/' . $safeFileName;
            $targetDir = storage_path('app/kml');
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0755, true);
            }
            file_put_contents(storage_path('app/' . $storedPath), $content);

            // Ekstrak placemarks dan koordinat baru untuk preview tabel & detail
            $parsedData = $this->parseKmlContent($content);

            $updateData['file_name'] = $originalName;
            $updateData['file_path'] = $storedPath;
            $updateData['raw_kml'] = $content;
            $updateData['data_json'] = json_encode($parsedData['placemarks']);
        }

        $project->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Data proyek KML berhasil diperbarui!',
            'data' => $project
        ]);
    }

    /**
     * Delete KML project
     */
    public function destroy($id)
    {
        $project = KmlProject::findOrFail($id);
        $projectName = $project->nama_project;

        // Hapus file fisik jika ada di storage
        if (!empty($project->file_path)) {
            $fullPath = storage_path('app/' . $project->file_path);
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => "Proyek KML '{$projectName}' berhasil dihapus!"
        ]);
    }

    /**
     * Download KML file (100% original if stored, or fallback to generated)
     */
    public function download($id)
    {
        $project = KmlProject::findOrFail($id);
        $fileName = ($project->file_name ?: ($project->nama_project . '.kml'));
        if (!str_ends_with(strtolower($fileName), '.kml')) {
            $fileName .= '.kml';
        }

        // 1. Prioritaskan unduh berkas asli fisik jika ada di storage
        if (!empty($project->file_path)) {
            $fullPath = storage_path('app/' . $project->file_path);
            if (file_exists($fullPath)) {
                $fileContent = file_get_contents($fullPath);
                return response($fileContent, 200, [
                    'Content-Type' => 'application/vnd.google-earth.kml+xml',
                    'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                ]);
            }
        }

        // 2. Jika ada di raw_kml (teks XML mentah utuh)
        if (!empty($project->raw_kml)) {
            return response($project->raw_kml, 200, [
                'Content-Type' => 'application/vnd.google-earth.kml+xml',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);
        }

        // 3. Fallback jika data lama yang belum punya raw file
        $kmlContent = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $kmlContent .= '<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2">' . "\n";
        $kmlContent .= '  <Document>' . "\n";
        $kmlContent .= '    <name>' . htmlspecialchars($project->nama_project) . '</name>' . "\n";
        $kmlContent .= '    <description>Exported from Telkom Akses Data Manager</description>' . "\n";

        $placemarks = json_decode($project->data_json, true) ?: [];
        $validCoords = [];
        $detectedCable = 'AC-OF-SM-48D';

        foreach ($placemarks as $pm) {
            $name = htmlspecialchars($pm['name'] ?? 'Titik Jaringan');
            $lat = (float)($pm['lat'] ?? 0);
            $lng = (float)($pm['lng'] ?? 0);
            $notes = htmlspecialchars($pm['notes'] ?? $pm['designator'] ?? $pm['category'] ?? '');

            if (!empty($pm['designator'])) {
                $des = strtoupper($pm['designator']);
                if (str_contains($des, 'KABEL') || str_contains($des, 'FO') || str_starts_with($des, 'AC-')) {
                    $detectedCable = $pm['designator'];
                }
            }

            if (abs($lat) > 0.0001 && abs($lng) > 0.0001) {
                $validCoords[] = "{$lng},{$lat},0";
            }

            $kmlContent .= '    <Placemark>' . "\n";
            $kmlContent .= '      <name>' . $name . '</name>' . "\n";
            if (!empty($notes)) {
                $kmlContent .= '      <description>' . $notes . '</description>' . "\n";
            }
            $kmlContent .= '      <Point>' . "\n";
            $kmlContent .= '        <coordinates>' . $lng . ',' . $lat . ',0</coordinates>' . "\n";
            $kmlContent .= '      </Point>' . "\n";
            $kmlContent .= '    </Placemark>' . "\n";
        }

        // Tambahkan LineString kabel distribusi menghubungkan koordinat survei valid
        if (count($validCoords) >= 2) {
            $coordsStr = implode("\n          ", $validCoords);
            $kmlContent .= '    <Placemark>' . "\n";
            $kmlContent .= '      <name>Jalur Kabel Distribusi</name>' . "\n";
            $kmlContent .= '      <description>' . htmlspecialchars($detectedCable) . ' 150m</description>' . "\n";
            $kmlContent .= '      <LineString>' . "\n";
            $kmlContent .= '        <tessellate>1</tessellate>' . "\n";
            $kmlContent .= '        <coordinates>' . "\n          " . $coordsStr . "\n        </coordinates>" . "\n";
            $kmlContent .= '      </LineString>' . "\n";
            $kmlContent .= '    </Placemark>' . "\n";
        }

        $kmlContent .= '  </Document>' . "\n";
        $kmlContent .= '</kml>';

        return response($kmlContent, 200, [
            'Content-Type' => 'application/vnd.google-earth.kml+xml',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    /**
     * Simple parser for uploaded KML files
     */
    private function parseKmlContent(string $xmlString): array
    {
        $placemarks = [];

        try {
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($xmlString);

            if ($xml !== false) {
                $xml->registerXPathNamespace('kml', 'http://www.opengis.net/kml/2.2');
                $elements = $xml->xpath('//kml:Placemark') ?: $xml->xpath('//Placemark') ?: [];

                foreach ($elements as $idx => $node) {
                    $name = (string)($node->name ?? ('Titik-' . ($idx + 1)));
                    $coordStr = '';

                    if (isset($node->Point->coordinates)) {
                        $coordStr = trim((string)$node->Point->coordinates);
                    } elseif (isset($node->coordinates)) {
                        $coordStr = trim((string)$node->coordinates);
                    }

                    $lat = 0;
                    $lng = 0;
                    if (!empty($coordStr)) {
                        $parts = explode(',', $coordStr);
                        if (count($parts) >= 2) {
                            $lng = (float)trim($parts[0]);
                            $lat = (float)trim($parts[1]);
                        }
                    }

                    $placemarks[] = [
                        'no' => $idx + 1,
                        'name' => $name,
                        'lat' => $lat,
                        'lng' => $lng,
                        'shape' => str_contains(strtoupper($name), 'ODC') ? 'square' : (str_contains(strtoupper($name), 'TIANG') ? 'donut' : 'triangle'),
                        'designator' => $this->guessDesignator($name),
                    ];
                }
            }
            libxml_clear_errors();
        } catch (\Throwable $e) {
            // Silently return what we have
        }

        return [
            'placemarks' => $placemarks,
        ];
    }

    /**
     * Helper to guess designator from name
     */
    private function guessDesignator(string $name): string
    {
        $upper = strtoupper($name);
        if (str_contains($upper, 'ODC')) return 'ODC-48';
        if (str_contains($upper, 'ODP')) return 'ODP-8';
        if (str_contains($upper, 'TIANG')) return 'TIANG-7M';
        if (str_contains($upper, 'CLOSURE')) return 'CLOSURE-24';
        return 'TITIK-JARINGAN';
    }

    /**
     * Get statistics for dashboard charts and KPI cards
     */
    public function getDashboardStats(Request $request)
    {
        // 1. Dapatkan daftar tahun unik yang tersedia
        $yearsFromSurvei = KmlProject::whereNotNull('tanggal_survei')
            ->selectRaw('YEAR(tanggal_survei) as yr')
            ->distinct()
            ->pluck('yr')
            ->toArray();

        $yearsFromCreated = KmlProject::selectRaw('YEAR(created_at) as yr')
            ->distinct()
            ->pluck('yr')
            ->toArray();

        $availableYears = array_unique(array_filter(array_merge($yearsFromSurvei, $yearsFromCreated)));
        rsort($availableYears);

        $currentYear = (int)date('Y');
        if (empty($availableYears)) {
            $availableYears = [$currentYear];
        }

        // Tentukan tahun dan bulan yang dipilih
        $selectedYear = $request->filled('year') && $request->year !== 'all' 
            ? (int)$request->year 
            : ($availableYears[0] ?? $currentYear);
        $selectedMonth = $request->input('month', 'all');

        // Query untuk proyek pada tahun terpilih
        $yearQuery = KmlProject::query();
        $yearQuery->where(function ($q) use ($selectedYear) {
            $q->whereYear('tanggal_survei', $selectedYear)
              ->orWhere(function ($sub) use ($selectedYear) {
                  $sub->whereNull('tanggal_survei')->whereYear('created_at', $selectedYear);
              });
        });

        // Hitung tren bulanan (12 bulan) untuk tahun terpilih
        $monthlyTrend = array_fill(0, 12, 0);
        $allProjectsInYear = (clone $yearQuery)->get(['id', 'tanggal_survei', 'created_at', 'area', 'data_json']);
        
        foreach ($allProjectsInYear as $p) {
            $date = $p->tanggal_survei ?: $p->created_at;
            if ($date) {
                $monthIndex = (int)date('n', strtotime($date)) - 1; // 0 - 11
                if ($monthIndex >= 0 && $monthIndex < 12) {
                    $monthlyTrend[$monthIndex]++;
                }
            }
        }

        // Filter jika bulan spesifik dipilih
        $filteredProjects = $allProjectsInYear;
        if ($selectedMonth !== 'all' && is_numeric($selectedMonth)) {
            $m = (int)$selectedMonth;
            $filteredProjects = $allProjectsInYear->filter(function ($p) use ($m) {
                $date = $p->tanggal_survei ?: $p->created_at;
                return $date && (int)date('n', strtotime($date)) === $m;
            });
        }

        // Hitung KPI & Distribusi Area
        $totalProjects = $filteredProjects->count();
        $totalPoints = 0;
        $areaCounts = [];

        foreach ($filteredProjects as $p) {
            $placemarks = json_decode($p->data_json, true) ?: [];
            $totalPoints += count($placemarks);

            $area = trim($p->area ?: 'Witel Regional');
            $areaCounts[$area] = ($areaCounts[$area] ?? 0) + 1;
        }

        arsort($areaCounts);

        return response()->json([
            'success' => true,
            'selected_year' => $selectedYear,
            'selected_month' => $selectedMonth,
            'available_years' => array_values($availableYears),
            'kpis' => [
                'total_projects' => $totalProjects,
                'total_points' => $totalPoints,
                'total_areas' => count($areaCounts),
            ],
            'monthly_trend' => $monthlyTrend,
            'area_distribution' => [
                'labels' => array_keys($areaCounts),
                'counts' => array_values($areaCounts),
            ]
        ]);
    }
}
