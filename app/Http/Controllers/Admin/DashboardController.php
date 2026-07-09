<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\TypeOfService;
use App\Models\User;


class DashboardController extends Controller
{
    // Menampilkan halaman dashboard khusus Administrator
    public function index()
    {
        // Hitung jumlah masing-masing master data untuk ditampilkan di stat card
        $totalCustomer = Customer::count();
        $totalUser     = User::count();
        $totalService  = TypeOfService::count();
        return view('admin.dashboard', compact('totalCustomer', 'totalUser', 'totalService'));
    }
}