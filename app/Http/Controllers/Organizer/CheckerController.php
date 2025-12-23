<?php

namespace App\Http\Controllers\Organizer; // Perhatikan namespace ini

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CheckerController extends Controller
{
    public function index()
    {
        $checkers = User::where('organizer_id', auth()->id())
            ->whereHas('role', function ($q) {
                $q->where('slug', 'checker');
            })->latest()->get();

        return view('checker.index', compact('checkers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:20|unique:users',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $role = Role::where('slug', 'checker')->first();

        User::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
            'organizer_id' => auth()->id(),
        ]);

        return back()->with('success', 'Checker baru berhasil didaftarkan.');
    }

    public function destroy($id)
    {
        $checker = User::where('id', $id)->where('organizer_id', auth()->id())->firstOrFail();
        $checker->delete();
        return back()->with('success', 'Checker berhasil dihapus.');
    }

    public function scan($id)
    {
        $event = Event::findOrFail($id);
        return view('checker.scan', compact('event'));
    }

    public function verifyTicket(Request $request, $eventId)
    {
        $ticketCode = $request->ticket_code;

        // 1. Cari tiket berdasarkan kode dan event_id
        $ticket = \App\Models\Ticket::where('ticket_code', $ticketCode)
            ->where('event_id', $eventId)
            ->first();

        if (!$ticket) {
            return response()->json(['status' => 'error', 'message' => 'Tiket tidak ditemukan!'], 404);
        }

        // 2. Cek status pembayaran
        if ($ticket->status !== 'paid') {
            return response()->json(['status' => 'error', 'message' => 'Tiket belum lunas!'], 400);
        }

        // 3. Cek apakah sudah check-in (Keamanan ganda)
        if ($ticket->is_checked_in) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Tiket sudah pernah digunakan pada ' . $ticket->checked_in_at
            ], 400);
        }

        // 4. Update status check-in
        $ticket->update([
            'is_checked_in' => true,
            'checked_in_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil! Selamat datang, ' . $ticket->user->full_name
        ]);
    }
}
