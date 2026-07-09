<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar semua user beserta levelnya
    public function index()
    {
        $users = User::with('level')->latest()->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    // Menampilkan form tambah user baru
    public function create()
    {
        $levels = Level::all(); // dropdown pilihan level (Administrator/Operator/Pimpinan)
        return view('admin.user.create', compact('levels'));
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'id_level' => 'required|exists:level,id',
            'name'     => 'required|string|max:50',
            'email'    => 'required|email|max:50|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'id_level' => $request->id_level,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // hash manual, sama seperti di Seeder
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    // Menampilkan form edit user
    public function edit(User $user)
    {
        $levels = Level::all();
        return view('admin.user.edit', compact('user', 'levels'));
    }

    // Memperbarui data user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'id_level' => 'required|exists:level,id',
            'name'     => 'required|string|max:50',
            'email'    => 'required|email|max:50|unique:users,email,' . $users->id, // abaikan email milik user ini sendiri saat cek unique
            'password' => 'nullable|string|min:6', // password boleh kosong = tidak diubah
        ]);

        $data = [
            'id_level' => $request->id_level,
            'name'     => $request->name,
            'email'    => $request->email,
        ];

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    // Menghapus user (hard delete, karena tabel user tidak punya deleted_at di ERD)
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}