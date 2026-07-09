<x-layout-app :title="'Data Customer'">

    {{-- Header halaman + tombol tambah --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">Data Customer</h3>
            <p class="text-muted small m-0">Kelola data pelanggan laundry.</p>
        </div>
        <a href="{{ route('admin.customer.create') }}" class="btn btn-primary px-4 py-2 rounded-3 d-flex align-items-center gap-2">
            <span>+</span> Tambah Customer
        </a>
    </div>

    {{-- Card pembungkus tabel --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted">
                    <tr>
                        <th class="px-4 py-3 fw-semibold">No</th>
                        <th class="px-4 py-3 fw-semibold">Nama Customer</th>
                        <th class="px-4 py-3 fw-semibold">Telepon</th>
                        <th class="px-4 py-3 fw-semibold">Alamat</th>
                        <th class="px-4 py-3 fw-semibold text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <td class="px-4 py-3 text-muted">{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
                            <td class="px-4 py-3 fw-bold text-dark">{{ $customer->customer_name }}</td>
                            <td class="px-4 py-3 font-monospace text-muted">{{ $customer->phone }}</td>
                            <td class="px-4 py-3 text-muted">{{ $customer->address }}</td>
                            <td class="px-4 py-3">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.customer.edit', $customer->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-2">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.customer.destroy', $customer->id) }}" method="POST" class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-2">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-5 text-center text-muted">
                                Belum ada data customer. Yuk tambahkan yang pertama 🧺
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $customers->links() }}
    </div>

</x-layout-app>