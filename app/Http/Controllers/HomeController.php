<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Ambil data events (sudah ada sebelumnya)
        $events = \App\Models\Event::latest()->take(8)->get();
        $categories = \App\Models\Category::all();

        // 2. Definisikan data Banner Carousel (Array)
        $banners = [
            [
                'image' => 'banner.jpg', // Pastikan file ini ada di public/images/
                'alt' => 'Promo Konser Besar'
            ],
            [
                'image' => 'banner3.jpg',
                'alt' => 'Workshop Kreatif'
            ],
            // Tambah lagi jika perlu
        ];

        return view('home', compact('events', 'categories', 'banners'));
    }

    public function show($id)
    {
        // Mencari event berdasarkan ID, jika tidak ada akan 404
        $event = Event::findOrFail($id);

        return view('events.show', compact('event'));
    }

    public function about()
    {
        return view('about');
    }
}
