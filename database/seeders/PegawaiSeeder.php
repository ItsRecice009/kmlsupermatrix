<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawaiList = [
            [
                'name' => 'Pegawai 1',
                'email' => 'pegawai1@telkom.com',
                'password' => Hash::make('Pegawai123!'),
            ],
            [
                'name' => 'Budi Rahmat',
                'email' => 'budi.rahmat@gmail.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Agus Santoso',
                'email' => 'agus.santoso@gmail.com',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($pegawaiList as $item) {
            Pegawai::updateOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => $item['password'],
                    'is_approved' => true,
                    'is_blocked' => false,
                    'approved_at' => now(),
                ]
            );
        }

        $this->command->info('✅ Pegawai accounts seeded successfully!');
        $this->command->info('  - pegawai1@telkom.com (Pass: Pegawai123!)');
        $this->command->info('  - budi.rahmat@gmail.com (Pass: password123)');
        $this->command->info('  - agus.santoso@gmail.com (Pass: password123)');
    }
}
