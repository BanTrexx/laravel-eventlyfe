<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $data = [
            'total_users' => User::count(),
            'total_events' => Event::count(),
            'total_organizers' => User::whereHas('role', fn($q) => $q->where('slug', 'organizer'))->count(),
        ];
        return view('admin.dashboard', $data);
    }
}
