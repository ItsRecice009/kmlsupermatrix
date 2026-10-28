<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin Utama (Razky Lawani)
        $this->call(AdminSeeder::class);

        // 2. Seed Pegawai
        $this->call(PegawaiSeeder::class);


        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('✅ All seeders completed successfully!');
        $this->command->info('========================================');
    }
}
