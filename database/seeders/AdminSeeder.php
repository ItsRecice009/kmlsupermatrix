<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin Utama (Razky Lawani)
        Admin::updateOrCreate(
            ['email' => 'razky@telkom.com'],
            [
                'name' => 'Razky Lawani',
                'password' => Hash::make('Admin123!'),
            ]
        );

        $this->command->info('✅ Admin account (Razky Lawani) seeded successfully!');
        $this->command->info('  - razky@telkom.com (Pass: Admin123!)');
    }
}

