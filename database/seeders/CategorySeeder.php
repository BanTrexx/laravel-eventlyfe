<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Musik', 'slug' => 'musik', 'icon' => 'bi-music-note-beamed', 'color' => 'warning'],
            ['name' => 'Workshop', 'slug' => 'workshop', 'icon' => 'bi-briefcase', 'color' => 'primary'],
            ['name' => 'Game', 'slug' => 'game', 'icon' => 'bi-controller', 'color' => 'danger'],
            ['name' => 'Hobi', 'slug' => 'hobi', 'icon' => 'bi-flower1', 'color' => 'success'],
            ['name' => 'Festival', 'slug' => 'festival', 'icon' => 'bi-calendar-event', 'color' => 'info'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::updateOrCreate($category);
        }
    }
}
