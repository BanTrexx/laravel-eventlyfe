<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\Role;
use App\Models\Category; // Tambahkan import ini
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cari Role Organizer & User-nya
        $organizerRole = Role::where('slug', 'organizer')->first();
        $organizer = User::where('role_id', $organizerRole->id)->first();

        // 2. Ambil kategori yang dibutuhkan dari database
        $musikCat = Category::where('slug', 'musik')->first();
        $workshopCat = Category::where('slug', 'workshop')->first();

        // 3. Masukkan data event dengan category_id yang sesuai
        Event::create([
            'organizer_id' => $organizer->id,
            'category_id'  => $musikCat->id, // Kategori Musik
            'name'         => 'Java Jazz Festival 2025',
            'description'  => 'Festival musik jazz terbesar tahun ini.',
            'date'         => '2026-10-20 19:00:00',
            'price'        => 750000,
            'image'        => 'jazz.jpg',
            'location'     => 'JIExpo Kemayoran',
            'quota'        => 500
        ]);

        Event::create([
            'organizer_id' => $organizer->id,
            'category_id'  => $musikCat->id, // Kategori Musik
            'name'         => 'Indie Rock Night',
            'description'  => 'Malam penuh distorsi dan lirik puitis.',
            'date'         => '2026-11-15 20:00:00',
            'price'        => 150000,
            'image'        => 'rock.png',
            'location'     => 'Livespace SCBD',
            'quota'        => 200
        ]);

        Event::create([
            'organizer_id' => $organizer->id,
            'category_id'  => $workshopCat->id, // Kategori Workshop
            'name'         => 'Workshop UI/UX Design',
            'description'  => 'Belajar desain dari ahlinya mahasiswa Telkom.',
            'date'         => '2026-09-05 09:00:00',
            'price'        => 50000,
            'image'        => 'workshop.png',
            'location'     => 'Co-working Space Tebet',
            'quota'        => 50
        ]);
    }
}
