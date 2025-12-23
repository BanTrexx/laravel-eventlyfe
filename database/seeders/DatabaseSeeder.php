<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role; // Pastikan Role di-import
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Wajib untuk enkripsi password
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Roles Terlebih Dahulu
        // Menggunakan updateOrCreate agar tidak duplikat jika seeder dijalankan ulang
        $adminRole = Role::updateOrCreate(['slug' => 'admin'], ['name' => 'Admin']);
        $orgRole   = Role::updateOrCreate(['slug' => 'organizer'], ['name' => 'Organizer']);
        $userRole  = Role::updateOrCreate(['slug' => 'user'], ['name' => 'User']);
        $checkRole = Role::updateOrCreate(['slug' => 'checker'], ['name' => 'Checker']);

        // 2. Seed Super Admin
        User::updateOrCreate(
            ['email' => 'admin@eventlyfe.com'], // Unik identifier
            [
                'username' => 'superadmin',
                'full_name' => 'Super Admin EventLyfe',
                'password' => Hash::make('Admin123!'), // Memenuhi syarat: Besar, Angka, Simbol
                'role_id' => $adminRole->id,
                'email_verified_at' => now(),
            ]
        );

        // 3. Seed Contoh Organizer (Untuk testing fitur organizer)
        User::updateOrCreate(
            ['email' => 'eo@eventlyfe.com'],
            [
                'username' => 'telkom_eo',
                'full_name' => 'IT Telkom Organizer',
                'password' => Hash::make('Organizer123!'),
                'role_id' => $orgRole->id,
                'organization_name' => 'Himpunan Mahasiswa TI Telkom Jakarta',
                'email_verified_at' => now(),
            ]
        );

        // 4. Memanggil Seeder Lain (EventSeeder)
        $this->call([
            CategorySeeder::class,
            EventSeeder::class,
        ]);
    }
}
