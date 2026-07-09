<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\TransOrder;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Menampilkan laporan penjualan, dengan opsi filter berdasarkan rentang tanggal
    public function index(Request $request)
    {
        // Query dasar: ambil semua transaksi beserta data customer-nya
        $query = TransOrder::with('customer');

        // Jika Pimpinan mengisi filter tanggal awal & akhir, terapkan filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('order_date', [$request->start_date, $request->end_date]);
        }

        // Urutkan dari transaksi terbaru, lalu paginasi
        $orders = $query->latest()->paginate(10)->withQueryString(); // withQueryString supaya filter tetap terbawa saat pindah halaman

        // Hitung total omzet keseluruhan dari hasil filter (bukan cuma yang tampil di halaman ini)
        $totalOmzet = (clone $query)->sum('total');

        // Hitung jumlah transaksi yang statusnya masih baru vs sudah diambil, untuk ringkasan
        $totalBaru        = (clone $query)->where('order_status', 0)->count();
        $totalSudahDiambil = (clone $query)->where('order_status', 1)->count();

        return view('pimpinan.laporan.index', compact(
            'orders',
            'totalOmzet',
            'totalBaru',
            'totalSudahDiambil'
        ));
    }

    // Menampilkan detail 1 transaksi (untuk melihat rincian jasa yang dipilih customer)
    public function show(TransOrder $order)
    {
        $order->load('customer', 'details.service');
        return view('pimpinan.laporan.show', compact('order'));
    }
}
