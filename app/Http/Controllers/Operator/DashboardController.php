<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\TransOrder;

class DashboardController extends Controller
{
    // Menampilkan dashboard Operator beserta ringkasan transaksi hari ini
    public function index()
    {
        // Jumlah transaksi yang dibuat hari ini
        $totalHariIni = TransOrder::whereDate('order_date', today())->count();

        // Jumlah laundry yang masih menunggu diambil (status 0)
        $totalMenunggu = TransOrder::where('order_status', 0)->count();

        // Jumlah laundry yang sudah selesai diambil (status 1)
        $totalSelesai = TransOrder::where('order_status', 1)->count();

        return view('operator.dashboard', compact('totalHariIni', 'totalMenunggu', 'totalSelesai'));
    }
}