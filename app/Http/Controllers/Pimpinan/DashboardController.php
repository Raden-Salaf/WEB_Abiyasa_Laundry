<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\TransOrder;

class DashboardController extends Controller
{
    // Menampilkan dashboard Pimpinan beserta ringkasan omzet & transaksi
    public function index()
    {
        // Total omzet dari semua transaksi (bukan hanya yang tampil di 1 halaman)
        $totalOmzet = TransOrder::sum('total');

        // Total jumlah transaksi keseluruhan
        $totalTransaksi = TransOrder::count();

        // Total transaksi bulan ini, untuk konteks tambahan
        $totalBulanIni = TransOrder::whereMonth('order_date', now()->month)
            ->whereYear('order_date', now()->year)
            ->count();

        return view('pimpinan.dashboard', compact('totalOmzet', 'totalTransaksi', 'totalBulanIni'));
    }
}