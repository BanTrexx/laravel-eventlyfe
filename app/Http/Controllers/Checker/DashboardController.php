<?php

namespace App\Http\Controllers\Checker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil user yang login (sebagai checker)
        $checker = auth()->user();

        // Ambil event yang ditugaskan ke checker ini melalui relasi belongsToMany
        // Pastikan di Model User sudah ada relasi 'assignedEvents'
        $events = $checker->assignedEvents()->with('category')->latest()->get();

        return view('checker.dashboard', compact('events'));
    }
}
