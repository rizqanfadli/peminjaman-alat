<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $activeBorrowers = Peminjam::where('status', 'dipinjam')->count();
        
        return Inertia::render('Dashboard', [
            'activeBorrowers' => $activeBorrowers
        ]);
    }
}
