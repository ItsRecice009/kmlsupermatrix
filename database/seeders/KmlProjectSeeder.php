<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KmlProject;

class KmlProjectSeeder extends Seeder
{
    public function run(): void
    {
        $sampleProjects = [
            [
                'nama_project' => 'Rute Feeder ODC-GTL-FBD Gorontalo',
                'area' => 'Witel Gorontalo',
                'tanggal_survei' => '2026-09-15',
                'file_name' => 'feeder_odc_gtl_fbd.kml',
                'created_by' => 'Razky Lawani',
                'placemarks' => [
                    ['name' => 'ODC-GTL-FBD', 'category' => 'ODC', 'lat' => 0.54012, 'lng' => 123.05981],
                    ['name' => 'Tiang-01', 'category' => 'Tiang', 'lat' => 0.54045, 'lng' => 123.06012],
                    ['name' => 'Tiang-02', 'category' => 'Tiang', 'lat' => 0.54082, 'lng' => 123.06050],
                    ['name' => 'Closure-C01', 'category' => 'Closure', 'lat' => 0.54120, 'lng' => 123.06095],
                    ['name' => 'ODP-GTL-FA01', 'category' => 'ODP', 'lat' => 0.54160, 'lng' => 123.06140],
                ],
            ],
            [
                'nama_project' => 'Distribusi Kluster Residensial ODP-ISM-FAV',
                'area' => 'Witel Makassar',
                'tanggal_survei' => '2026-08-20',
                'file_name' => 'distribusi_odp_ism_fav.kml',
                'created_by' => 'Budi Rahmat',
                'placemarks' => [
                    ['name' => 'ODC-ISM-MAIN', 'category' => 'ODC', 'lat' => 0.55120, 'lng' => 123.08110],
                    ['name' => 'Tiang-A01', 'category' => 'Tiang', 'lat' => 0.55150, 'lng' => 123.08145],
                    ['name' => 'ODP-ISM-FAV', 'category' => 'ODP', 'lat' => 0.55210, 'lng' => 123.08210],
                ],
            ],
            [
                'nama_project' => 'Ekspansi Rute Backbone Fiber STO Telkom',
                'area' => 'Witel Makassar',
                'tanggal_survei' => '2026-08-05',
                'file_name' => 'backbone_sto_telkom.kml',
                'created_by' => 'Razky Lawani',
                'placemarks' => [
                    ['name' => 'STO-CENTRAL', 'category' => 'STO', 'lat' => 0.53500, 'lng' => 123.05000],
                    ['name' => 'MH-01', 'category' => 'Manhole', 'lat' => 0.53540, 'lng' => 123.05050],
                    ['name' => 'Tiang-B01', 'category' => 'Tiang', 'lat' => 0.53580, 'lng' => 123.05100],
                    ['name' => 'ODC-BBN-01', 'category' => 'ODC', 'lat' => 0.53620, 'lng' => 123.05150],
                ],
            ],
            [
                'nama_project' => 'Pemasangan ODP Baru Sektor Limboto',
                'area' => 'Witel Gorontalo',
                'tanggal_survei' => '2026-06-12',
                'file_name' => 'odp_limboto_cluster.kml',
                'created_by' => 'Ahmad Syahrir',
                'placemarks' => [
                    ['name' => 'ODC-LBT-01', 'category' => 'ODC', 'lat' => 0.62000, 'lng' => 122.98000],
                    ['name' => 'ODP-LBT-01', 'category' => 'ODP', 'lat' => 0.62100, 'lng' => 122.98100],
                    ['name' => 'ODP-LBT-02', 'category' => 'ODP', 'lat' => 0.62150, 'lng' => 122.98180],
                ],
            ],
            [
                'nama_project' => 'Modernisasi Jalur Kabel Feeder Manado Utara',
                'area' => 'Witel Manado',
                'tanggal_survei' => '2026-05-18',
                'file_name' => 'feeder_mnd_utara.kml',
                'created_by' => 'Siti Nurhaliza',
                'placemarks' => [
                    ['name' => 'ODC-MND-04', 'category' => 'ODC', 'lat' => 1.48000, 'lng' => 124.84000],
                    ['name' => 'Tiang-M01', 'category' => 'Tiang', 'lat' => 1.48100, 'lng' => 124.84100],
                    ['name' => 'Tiang-M02', 'category' => 'Tiang', 'lat' => 1.48200, 'lng' => 124.84200],
                    ['name' => 'ODP-MND-FA08', 'category' => 'ODP', 'lat' => 1.48300, 'lng' => 124.84300],
                ],
            ],
            [
                'nama_project' => 'Survei Jaringan Akses Baru Palu Timur',
                'area' => 'Witel Palu',
                'tanggal_survei' => '2026-03-24',
                'file_name' => 'akses_palu_timur.kml',
                'created_by' => 'Budi Rahmat',
                'placemarks' => [
                    ['name' => 'ODC-PLU-02', 'category' => 'ODC', 'lat' => -0.89000, 'lng' => 119.87000],
                    ['name' => 'ODP-PLU-A01', 'category' => 'ODP', 'lat' => -0.89100, 'lng' => 119.87100],
                ],
            ],
            [
                'nama_project' => 'Penataan Jaringan Fiber STO Kendari Kota',
                'area' => 'Witel Kendari',
                'tanggal_survei' => '2025-11-10',
                'file_name' => 'sto_kendari_kota.kml',
                'created_by' => 'Razky Lawani',
                'placemarks' => [
                    ['name' => 'ODC-KDR-01', 'category' => 'ODC', 'lat' => -3.99000, 'lng' => 122.51000],
                    ['name' => 'ODP-KDR-B01', 'category' => 'ODP', 'lat' => -3.99100, 'lng' => 122.51100],
                ],
            ],
        ];

        foreach ($sampleProjects as $projData) {
            $placemarks = $projData['placemarks'] ?? [];

            KmlProject::updateOrCreate(
                ['nama_project' => $projData['nama_project']],
                [
                    'nama_project' => $projData['nama_project'],
                    'area' => $projData['area'],
                    'tanggal_survei' => $projData['tanggal_survei'],
                    'file_name' => $projData['file_name'],
                    'data_json' => json_encode($placemarks),
                    'created_by' => $projData['created_by'],
                    'created_at' => $projData['tanggal_survei'] . ' 10:00:00',
                ]
            );
        }

        $this->command->info('✅ Sample KML projects seeded successfully with multi-month survey dates!');
    }
}
