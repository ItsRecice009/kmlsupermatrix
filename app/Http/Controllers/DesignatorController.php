<?php

namespace App\Http\Controllers;

use App\Models\DesignatorModel;
use Illuminate\Http\Request;

class DesignatorController extends Controller
{
    // Ambil semua data designator
    public function index()
    {
        $designators = DesignatorModel::all();
        return response()->json($designators);
    }

    // Tambah data baru
    public function store(Request $request)
    {
        // Hanya super_admin, admin, dan pegawai yang bisa menambah designator
        if (!auth()->check() || !auth()->user()->canManageDesignators()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Anda tidak memiliki akses untuk menambah designator.'
            ], 403);
        }

        $request->validate([
            'nama_designator' => 'required|string|max:255|unique:designators,nama_designator',
            'rumus' => 'nullable|string'
        ], [
            'nama_designator.required' => 'Nama designator tidak boleh kosong',
            'nama_designator.unique' => 'Designator ini sudah terdaftar!'
        ]);

        $identifier = (string) auth()->user()->getAuthIdentifier();

        $designator = DesignatorModel::create([
            'admin_id' => str_starts_with($identifier, 'admin_') ? (int) substr($identifier, 6) : null,
            'nama_designator' => $request->nama_designator,
            'rumus' => $request->rumus
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $designator
        ], 201);
    }

    // Update data
    public function update(Request $request, $id)
    {
        // Hanya super_admin, admin, dan pegawai yang bisa mengupdate designator
        if (!auth()->check() || !auth()->user()->canManageDesignators()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Anda tidak memiliki akses untuk mengubah designator.'
            ], 403);
        }

        $request->validate([
            'nama_designator' => 'required|string|max:255|unique:designators,nama_designator,' . $id,
            'rumus' => 'nullable|string'
        ], [
            'nama_designator.required' => 'Nama designator tidak boleh kosong',
            'nama_designator.unique' => 'Designator ini sudah digunakan oleh data lain!'
        ]);

        $designator = DesignatorModel::findOrFail($id);
        $designator->update([
            'nama_designator' => $request->nama_designator,
            'rumus' => $request->rumus
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $designator
        ]);
    }

    // Hapus data
    public function destroy($id)
    {
        // Hanya super_admin, admin, dan pegawai yang bisa menghapus designator
        if (!auth()->check() || !auth()->user()->canManageDesignators()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Anda tidak memiliki akses untuk menghapus designator.'
            ], 403);
        }

        $designator = DesignatorModel::findOrFail($id);
        $designator->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    // Validasi designator dari KML
    public function validateDesignators(Request $request)
    {
        $request->validate([
            'designators' => 'required|array',
            'designators.*' => 'string'
        ]);

        // Ambil semua designator dari database
        $validDesignators = DesignatorModel::pluck('nama_designator')->toArray();
        
        // Normalize untuk case-insensitive comparison
        $validDesignatorsLower = array_map('strtolower', $validDesignators);
        $validDesignatorsMap = array_combine($validDesignatorsLower, $validDesignators);

        $results = [];
        foreach ($request->designators as $designator) {
            $designatorLower = strtolower(trim($designator));
            
            if (isset($validDesignatorsMap[$designatorLower])) {
                $results[] = [
                    'input' => $designator,
                    'valid' => true,
                    'matched' => $validDesignatorsMap[$designatorLower],
                    'message' => 'Valid'
                ];
            } else {
                // Cari yang mirip (fuzzy matching)
                $similar = $this->findSimilar($designator, $validDesignators);
                
                $results[] = [
                    'input' => $designator,
                    'valid' => false,
                    'matched' => null,
                    'suggestions' => $similar,
                    'message' => empty($similar) ? 'Tidak ditemukan di database' : 'Mungkin maksud Anda: ' . implode(', ', array_slice($similar, 0, 3))
                ];
            }
        }

        return response()->json([
            'success' => true,
            'results' => $results,
            'total' => count($request->designators),
            'valid_count' => count(array_filter($results, fn($r) => $r['valid'])),
            'invalid_count' => count(array_filter($results, fn($r) => !$r['valid']))
        ]);
    }

    // Helper function untuk mencari designator yang mirip
    private function findSimilar($input, $validDesignators, $threshold = 3)
    {
        $similar = [];
        $inputLower = strtolower($input);
        
        foreach ($validDesignators as $valid) {
            $validLower = strtolower($valid);
            $distance = levenshtein($inputLower, $validLower);
            
            if ($distance <= $threshold) {
                $similar[] = $valid;
            }
        }
        
        return $similar;
    }
}