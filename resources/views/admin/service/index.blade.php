<x-layout-app :title="'Data Jenis Service'">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="fw-bold">
            <marquee behavior="" direction="">
                <h3 class="fw-bold text-dark m-0">Data Jenis Service</h3>
            </marquee>
            <p class="text-muted small m-0">Kelola jenis jasa laundry beserta harga per kg.</p>
        </div>
        <a href="{{ route('admin.service.create') }}"
            class="btn btn-primary px-4 py-2 rounded-3 d-flex align-items-center gap-2">
            <span>+</span> Tambah Jenis Service
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted">
                    <tr>
                        <th class="px-4 py-3 fw-semibold">No</th>
                        <th class="px-4 py-3 fw-semibold">Nama Jasa</th>
                        <th class="px-4 py-3 fw-semibold">Harga / Kg</th>
                        <th class="px-4 py-3 fw-semibold">Deskripsi</th>
                        <th class="px-4 py-3 fw-semibold text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td class="px-4 py-3 text-muted">
                                {{ ($services->currentPage() - 1) * $services->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 py-3 fw-bold text-dark">{{ $service->service_name }}</td>
                            <td class="px-4 py-3 font-monospace fw-bold text-success">Rp
                                {{ number_format($service->price, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-muted">{{ $service->description ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.service.edit', $service->id) }}"
                                        class="btn btn-sm btn-primary px-3 rounded-2">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST"
                                        class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-3 rounded-2">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-5 text-center text-muted">
                                Belum ada data jenis service. Yuk tambahkan yang pertama 🧺
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $services->links() }}
    </div>

</x-layout-app>
