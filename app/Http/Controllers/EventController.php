<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category; // Import Model Category
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // ... method index tetap sama ...

    /**
     * Tampilkan form buat event dengan daftar kategori.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255', // Validasi lokasi
            'date' => 'required|date',
            'price' => 'required|numeric',
            'quota' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required',
        ]);

        $imagePath = $request->file('image')->store('events', 'public');

        \App\Models\Event::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'category_id' => $request->category_id,
            'location' => $request->location, // Simpan lokasi
            'date' => $request->date,
            'price' => $request->price,
            'quota' => $request->quota,
            'image' => $imagePath,
            'description' => $request->description,
            'organizer_id' => auth()->id(),
        ]);

        return redirect()->route('organizer.dashboard')->with('success', 'Event berhasil dibuat!');
    }

    public function allEvents(Request $request)
    {
        $query = Event::query();

        // Filter Pencarian Nama
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter Lokasi
        if ($request->has('location') && $request->location != '') {
            $query->where('location', $request->location);
        }

        // Ambil data dengan pagination (12 event per halaman)
        $events = $query->latest()->paginate(12)->withQueryString();

        // Ambil daftar lokasi unik untuk pilihan filter
        $locations = Event::select('location')->distinct()->pluck('location');

        return view('events.all', compact('events', 'locations'));
    }

    public function show($id)
    {
        // Eager load kategori agar data icon/warna tersedia
        $event = Event::with('category')->findOrFail($id);

        // Rekomendasi event terkait (opsional, dari kategori yang sama)
        $relatedEvents = Event::where('category_id', $event->category_id)
            ->where('id', '!=', $event->id)
            ->take(4)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }

    /**
     * Tampilkan form edit dengan kategori yang terpilih.
     */
    public function edit($id)
    {
        // Pastikan event ditemukan dan benar milik organizer yang sedang login
        $event = \App\Models\Event::where('id', $id)
            ->where('organizer_id', auth()->id())
            ->firstOrFail();

        $categories = \App\Models\Category::all();
        return view('events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $event = \App\Models\Event::where('id', $id)
            ->where('organizer_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'date' => 'required',
            'price' => 'required|numeric',
            'quota' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Image opsional saat edit
            'description' => 'required',
        ]);

        $data = $request->all();
        $data['slug'] = \Str::slug($request->name);

        // Logika Penggantian Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage jika ada
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('events', 'public');
        } else {
            // Jika tidak upload baru, gunakan gambar yang lama
            $data['image'] = $event->image;
        }

        $event->update($data);

        return redirect()->route('organizer.dashboard')->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Pastikan event milik organizer yang login
        $event = \App\Models\Event::where('id', $id)
            ->where('organizer_id', auth()->id())
            ->firstOrFail();

        // 1. Hapus file gambar dari storage
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        // 2. Hapus data dari database
        $event->delete();

        return redirect()->route('organizer.dashboard')->with('success', 'Event berhasil dihapus secara permanen!');
    }

    // Tambahkan di EventController.php

    public function assignCheckers(Request $request, $id)
    {
        $event = \App\Models\Event::where('id', $id)
            ->where('organizer_id', auth()->id())
            ->firstOrFail();

        // Validasi: Pastikan checker_ids adalah array dan milik organizer ini
        $request->validate([
            'checker_ids' => 'array',
            'checker_ids.*' => 'exists:users,id'
        ]);

        // Sinkronisasi relasi many-to-many
        $event->checkers()->sync($request->checker_ids);

        return back()->with('success', 'Tim Checker berhasil ditugaskan!');
    }
}
