<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $activeBorrowers = Peminjam::where('status', 'dipinjam')->count();
        
        $startDate = Carbon::now()->subYear()->startOfDay();
        
        $monthlyBorrowers = Peminjam::selectRaw('DATE_FORMAT(tanggal_peminjaman, "%M %Y") as month')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('MIN(tanggal_peminjaman) as ordering_date')
            ->where('tanggal_peminjaman', '>=', $startDate)
            ->where('tanggal_peminjaman', '<=', Carbon::now())
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
