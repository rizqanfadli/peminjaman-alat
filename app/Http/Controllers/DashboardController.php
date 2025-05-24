<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $activeBorrowers = Peminjam::where('status', 'dipinjam')->count();
        
        // Perbaikan query untuk monthly borrowers
        $monthlyBorrowers = Peminjam::selectRaw('DATE_FORMAT(tanggal_peminjaman, "%M %Y") as month')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('MIN(tanggal_peminjaman) as ordering_date')  // tambahan untuk ordering
            ->where('tanggal_peminjaman', '>=', now()->subMonths(6))
            ->groupBy(DB::raw('DATE_FORMAT(tanggal_peminjaman, "%M %Y")'))
            ->orderBy('ordering_date', 'asc')
            ->get()
            ->map(function($item) {
                return [
                    'month' => $item->month,
                    'count' => $item->count
                ];
            });

        return Inertia::render('Dashboard', [
            'activeBorrowers' => $activeBorrowers,
            'monthlyBorrowers' => $monthlyBorrowers
        ]);
    }
}
