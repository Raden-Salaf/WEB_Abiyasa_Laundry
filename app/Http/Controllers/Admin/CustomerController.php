<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Menampilkan daftar semua customer
    public function index()
    {
        $customers = Customer::latest()->paginate(10); // ambil data terbaru, dipaginasi 10 per halaman

        return view('admin.customer.index', compact('customers'));
    }

    // Menampilkan form tambah customer baru
    public function create()
    {
        return view('admin.customer.create');
    }

    // Menyimpan data customer baru ke database
    public function store(Request $request)
    {
        // Validasi input sesuai struktur kolom di tabel customer
        $request->validate([
            'customer_name' => 'required|string|max:50',
            'phone' => 'required|string|max:13',
            'address' => 'required|string',
        ]);

        Customer::create($request->only('customer_name', 'phone', 'address'));

        return redirect()->route('admin.customer.index')->with('success', 'Customer berhasil ditambahkan.');
    }

    // Menampilkan form edit customer
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', compact('customer'));
    }

    // Memperbarui data customer
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'customer_name' => 'required|string|max:50',
            'phone' => 'required|string|max:13',
            'address' => 'required|string',
        ]);

        $customer->update($request->only('customer_name', 'phone', 'address'));

        return redirect()->route('admin.customer.index')->with('success', 'Customer berhasil diperbarui.');
    }

    // Menghapus data customer (soft delete karena Model pakai SoftDeletes)
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customer.index')->with('success', 'Customer berhasil dihapus.');
    }
}
