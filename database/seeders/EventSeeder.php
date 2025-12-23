<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil Role Organizer dan User-nya
        $organizer = User::whereHas('role', function ($q) {
            $q->where('slug', 'organizer');
        })->first();

        // 2. Ambil Semua Kategori berdasarkan Slug
        $catMusik    = Category::where('slug', 'musik')->first();
        $catWorkshop = Category::where('slug', 'workshop')->first();
        $catGame     = Category::where('slug', 'game')->first();
        $catHobi     = Category::where('slug', 'hobi')->first();
        $catFestival = Category::where('slug', 'festival')->first();

        $events = [
            // --- KATEGORI MUSIK ---
            [
                'organizer_id' => $organizer->id,
                'category_id'  => $catMusik->id,
                'name'         => 'Soulful Jazz Night 2026',
                'description'  => 'Malam syahdu bersama musisi jazz lokal dan internasional terbaik.',
                'date'         => '2026-03-15 19:30:00',
                'price'        => 350000,
                'image'        => 'jazz_night.jpg',
                'location'     => 'Motion Blue, Jakarta',
                'quota'        => 150
            ],
            [
                'organizer_id' => $organizer->id,
                'category_id'  => $catMusik->id,
                'name'         => 'Summer Techno Rave',
                'description'  => 'Pesta musik elektronik tepi pantai dengan DJ ternama.',
                'date'         => '2026-07-20 21:00:00',
                'price'        => 500000,
                'image'        => 'rave.jpg',
                'location'     => 'Beach City International Stadium, Ancol',
                'quota'        => 1000
            ],

            // --- KATEGORI WORKSHOP ---
            [
                'organizer_id' => $organizer->id,
                'category_id'  => $catWorkshop->id,
                'name'         => 'Laravel Advanced Masterclass',
                'description'  => 'Kupas tuntas arsitektur Laravel bersama para kontributor open source.',
                'date'         => '2026-02-10 09:00:00',
                'price'        => 250000,
                'image'        => 'laravel_ws.png',
                'location'     => 'Co-working Space Menteng',
                'quota'        => 40
            ],
            [
                'organizer_id' => $organizer->id,
                'category_id'  => $catWorkshop->id,
                'name'         => 'Product Management 101',
                'description'  => 'Belajar cara membangun produk yang dicintai pengguna dari para PM Tech Giant.',
                'date'         => '2026-04-05 10:00:00',
                'price'        => 150000,
                'image'        => 'pm_workshop.png',
                'location'     => 'Menara Bynea, Kuningan',
                'quota'        => 60
            ],

            // --- KATEGORI GAME ---
            [
                'organizer_id' => $organizer->id,
                'category_id'  => $catGame->id,
                'name'         => 'Valorant Community Cup 2026',
                'description'  => 'Turnamen komunitas Valorant terbesar dengan total hadiah puluhan juta rupiah.',
                'date'         => '2026-05-12 13:00:00',
                'price'        => 50000,
                'image'        => 'valorant.jpg',
                'location'     => 'Point Blank Arena, Jakarta',
                'quota'        => 128
            ],
            [
                'organizer_id' => $organizer->id,
                'category_id'  => $catGame->id,
                'name'         => 'Mobile Legends National Open',
                'description'  => 'Ajang pencarian bakat player MLBB profesional tingkat nasional.',
                'date'         => '2026-08-25 10:00:00',
                'price'        => 75000,
                'image'        => 'mlbb.png',
                'location'     => 'Mall Taman Anggrek Atrium',
                'quota'        => 256
            ],

            // --- KATEGORI HOBI ---
            [
                'organizer_id' => $organizer->id,
                'category_id'  => $catHobi->id,
                'name'         => 'Bonsai & Succulent Expo',
                'description'  => 'Pameran dan bursa tanaman hias unik dari berbagai penjuru daerah.',
                'date'         => '2026-06-18 08:00:00',
                'price'        => 25000,
                'image'        => 'bonsai_expo.jpg',
                'location'     => 'Kebun Raya Bogor',
                'quota'        => 300
            ],
            [
                'organizer_id' => $organizer->id,
                'category_id'  => $catHobi->id,
                'name'         => 'Pottery Wheel for Beginners',
                'description'  => 'Belajar membuat keramik sendiri dari tanah liat menggunakan teknik roda putar.',
                'date'         => '2026-09-10 14:00:00',
                'price'        => 450000,
                'image'        => 'pottery.png',
                'location'     => 'Clay Studio, Jakarta Selatan',
                'quota'        => 15
            ],

            // --- KATEGORI FESTIVAL ---
            [
                'organizer_id' => $organizer->id,
                'category_id'  => $catFestival->id,
                'name'         => 'Jakarta Food Festival 2026',
                'description'  => 'Pesta kuliner nusantara dengan lebih dari 200 tenant makanan legendaris.',
                'date'         => '2026-10-05 10:00:00',
                'price'        => 30000,
                'image'        => 'food_fest.jpg',
                'location'     => 'Lapangan Parkir Timur Senayan',
                'quota'        => 2000
            ],
            [
                'organizer_id' => $organizer->id,
                'category_id'  => $catFestival->id,
                'name'         => 'Anime Fest Indonesia',
                'description'  => 'Pertemuan akbar para pecinta anime, manga, dan cosplayer se-Indonesia.',
                'date'         => '2026-12-15 09:00:00',
                'price'        => 100000,
                'image'        => 'anime_fest.png',
                'location'     => 'ICE BSD, Tangerang',
                'quota'        => 5000
            ],
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }
    }
}
