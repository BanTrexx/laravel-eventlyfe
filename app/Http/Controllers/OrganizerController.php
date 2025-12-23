<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function index()
    {
        $organizerId = auth()->id();

        // 1. Total Event yang dibuat organizer
        $events_count = Event::where('organizer_id', $organizerId)->count();

        // 2. Total Tiket Terjual (Hanya yang statusnya 'paid')
        // Kita cek tiket yang event-nya milik organizer ini
        $total_tickets = \App\Models\Ticket::whereHas('event', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->where('status', 'paid')->count();

        // 3. Total Pembayaran Perlu Verifikasi
        // Tiket yang statusnya 'pending' DAN sudah upload bukti transfer
        $pending_payments = \App\Models\Ticket::whereHas('event', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->where('status', 'pending')
            ->whereNotNull('payment_proof')
            ->count();

        // 4. Total Tim Checker
        $total_checkers = User::where('organizer_id', $organizerId)
            ->whereHas('role', function ($q) {
                $q->where('slug', 'checker');
            })->count();

        // 5. Daftar Event untuk Tabel
        $events = Event::where('organizer_id', $organizerId)
            ->withCount(['tickets' => function ($q) {
                $q->where('status', 'paid'); // Menghitung peserta yang sudah bayar saja
            }])
            ->latest()
            ->get();

        return view('organizer.dashboard', compact(
            'events',
            'events_count',
            'total_tickets',
            'pending_payments',
            'total_checkers'
        ));
    }

    public function verifications()
    {
        $organizerId = auth()->id();

        // Ambil tiket yang event-nya dibuat oleh organizer ini
        // dan statusnya masih pending tapi sudah ada bukti pembayarannya
        $pendingTickets = \App\Models\Ticket::whereHas('event', function ($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })
            ->whereNotNull('payment_proof')
            ->where('status', 'pending')
            ->with(['user', 'event'])
            ->latest()
            ->get();

        return view('organizer.verifications.index', compact('pendingTickets'));
    }

    public function approveTicket($id)
    {
        $ticket = \App\Models\Ticket::findOrFail($id);

        dd([
            'ID_Anda_Saat_Ini' => auth()->id(),
            'Owner_Event_Ini' => $ticket->event->organizer_id,
            'Apakah_Cocok' => auth()->id() == $ticket->event->organizer_id
        ]);

        // Pastikan ini memang tiket untuk event milik organizer yang login
        if ($ticket->event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $ticket->update(['status' => 'paid']);

        return back()->with('success', 'Pembayaran berhasil diverifikasi. Tiket sekarang aktif!');
    }

    public function rejectTicket($id)
    {
        $ticket = \App\Models\Ticket::findOrFail($id);

        if ($ticket->event->organizer_id !== auth()->id()) {
            abort(403);
        }

        $ticket->update(['status' => 'cancelled']);

        return back()->with('success', 'Pembayaran ditolak.');
    }
}
