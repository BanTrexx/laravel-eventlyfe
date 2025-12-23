<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function profile()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }

    public function tickets()
    {
        // Ambil tiket milik user beserta data event-nya
        $tickets = auth()->user()->tickets()->with('event')->latest()->get();

        return view('user.tickets', compact('tickets'));
    }

    public function showTicket($id)
    {
        $ticket = \App\Models\Ticket::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('user.show', compact('ticket'));
    }

    // Tampilan khusus Print
    public function printTicket($id)
    {
        $ticket = \App\Models\Ticket::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('user.print', compact('ticket'));
    }

    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $ticket = auth()->user()->tickets()->findOrFail($id);

        if ($request->hasFile('payment_proof')) {
            // Simpan file ke folder storage/public/proofs
            $path = $request->file('payment_proof')->store('proofs', 'public');

            // Update data tiket
            $ticket->update([
                'payment_proof' => $path,
                // Opsional: Kamu bisa ubah status ke 'process' jika ada, atau tetap 'pending'
            ]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu verifikasi organizer.');
    }

    public function showCheckout($id)
    {
        $event = Event::findOrFail($id);
        return view('user.checkout', compact('event'));
    }

    public function checkout(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'quantity' => 'required|integer|min:1|max:5', // Batasi misal max 5 tiket per transaksi
        ]);

        $event = Event::findOrFail($request->event_id);

        // 2. Cek Kuota
        if ($event->quota < $request->quantity) {
            return back()->with('error', 'Maaf, kuota tiket tidak mencukupi.');
        }

        // 3. Simpan Tiket ke Database
        // Kita looping berdasarkan quantity yang dibeli
        for ($i = 0; $i < $request->quantity; $i++) {
            Ticket::create([
                'user_id'       => auth()->id(),
                'event_id'      => $event->id,
                'ticket_code'   => 'TKT-' . strtoupper(Str::random(10)), // Generate kode unik
                'price'         => $event->price,
                'status'        => 'pending',
                'is_scanned'    => false,
            ]);
        }

        // 4. Update Kuota Event
        $event->decrement('quota', $request->quantity);

        return redirect()->route('my.tickets')->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }
}
