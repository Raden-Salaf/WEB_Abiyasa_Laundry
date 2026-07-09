<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeOfService;
use Illuminate\Http\Request;

class TypeOfServiceController extends Controller
{
    // Menampilkan daftar semua jenis jasa laundry
    public function index()
    {
        $services = TypeOfService::latest()->paginate(10);
        return view('admin.service.index', compact('services'));
    }

    // Menampilkan form tambah jenis jasa baru
    public function create()
    {
        return view('admin.service.create');
    }

    // Menyimpan jenis jasa baru
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:50',
            'price'        => 'required|integer|min:0',
            'description'  => 'nullable|string',
        ]);

        TypeOfService::create($request->only('service_name', 'price', 'description'));

        return redirect()->route('admin.service.index')->with('success', 'Jenis service berhasil ditambahkan.');
    }

    // Menampilkan form edit jenis jasa
    public function edit(TypeOfService $service)
    {
        return view('admin.service.edit', compact('service'));
    }

    // Memperbarui jenis jasa
    public function update(Request $request, TypeOfService $service)
    {
        $request->validate([
            'service_name' => 'required|string|max:50',
            'price'        => 'required|integer|min:0',
            'description'  => 'nullable|string',
        ]);

        $service->update($request->only('service_name', 'price', 'description'));

        return redirect()->route('admin.service.index')->with('success', 'Jenis service berhasil diperbarui.');
    }

    // Menghapus jenis jasa (soft delete)
    public function destroy(TypeOfService $service)
    {
        $service->delete();

        return redirect()->route('admin.service.index')->with('success', 'Jenis service berhasil dihapus.');
    }
}
