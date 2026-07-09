<x-layout-app :title="'Laporan Penjualan'">

    <div class="mb-4">
        <h3 class="fw-bold text-dark m-0">Laporan Penjualan</h3>
        <p class="text-muted small m-0">Ringkasan dan detail seluruh transaksi laundry.</p>
    </div>

    {{-- Form filter tanggal --}}
    <div class="card shadow-sm border-0 rounded-4 p-4 mb-4 bg-white">
        <form method="GET" action="{{ route('pimpinan.laporan.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3 col-sm-6">
                <label class="form-label text-muted small fw-semibold">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control rounded-3">
            </div>
            <div class="col-md-3 col-sm-6">
                <label class="form-label text-muted small fw-semibold">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control rounded-3">
            </div>
            <div class="col-md-auto d-flex gap-2 align-items-center">
                <button type="submit" class="btn btn-primary px-4 rounded-3 fw-semibold">
                    Filter
                </button>
                <a href="{{ route('pimpinan.laporan.index') }}"
                    class="text-decoration-none text-muted small fw-semibold">Reset</a>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-success bg-gradient text-white p-4">
                <p class="text-white-50 m-0 small fw-semibold">Total Omzet</p>
                <h2 class="fw-bold my-2 font-monospace">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-warning bg-gradient text-dark p-4">
                <p class="text-dark-50 m-0 small fw-semibold text-muted">Transaksi Baru</p>
                <h2 class="fw-bold my-2 font-monospace">{{ $totalBaru }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-primary bg-gradient text-white p-4">
                <p class="text-white-50 m-0 small fw-semibold">Sudah Diambil</p>
                <h2 class="fw-bold my-2 font-monospace">{{ $totalSudahDiambil }}</h2>
            </div>
        </div>
    </div>

    {{-- Tabel detail transaksi --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted">
                    <tr>
                        <th class="px-4 py-3 fw-semibold">No</th>
                        <th class="px-4 py-3 fw-semibold">Kode Order</th>
                        <th class="px-4 py-3 fw-semibold">Customer</th>
                        <th class="px-4 py-3 fw-semibold">Tanggal</th>
                        <th class="px-4 py-3 fw-semibold">Total</th>
                        <th class="px-4 py-3 fw-semibold">Status</th>
                        <th class="px-4 py-3 fw-semibold">Pembayaran</th>
                        <th class="px-4 py-3 fw-semibold text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-4 py-3 text-muted">
                                {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                            <td class="px-4 py-3 font-monospace fw-bold text-dark">{{ $order->order_code }}</td>
                            <td class="px-4 py-3 text-dark">{{ $order->customer->customer_name ?? 'Pelanggan Terhapus' }}
                            </td>
                            <td class="px-4 py-3 text-muted">
                                {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3 font-monospace fw-bold text-success">Rp
                                {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                @if ($order->order_status == 0)
                                    <span
                                        class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-semibold text-xs">Baru</span>
                                @else
                                    <span class="badge bg-success text-white px-3 py-1.5 rounded-pill fw-semibold text-xs">Sudah
                                        Diambil</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($order->order_pay > 0)
                                    <span
                                        class="badge bg-success text-white px-3 py-1.5 rounded-pill fw-semibold text-xs">Lunas</span>
                                @else
                                    <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-semibold text-xs">Belum
                                        Dibayar</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end">
                                <a href="{{ route('pimpinan.laporan.show', $order->id) }}"
                                    class="btn btn-sm btn-outline-primary px-3 rounded-2">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-5 text-center text-muted">
                                Tidak ada data transaksi pada rentang tanggal ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>

</x-layout-app>