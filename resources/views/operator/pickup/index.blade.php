<x-layout-app :title="'Pengambilan Laundry'">

    <div class="mb-4">
        <h3 class="fw-bold text-dark m-0">Daftar Laundry Siap Diambil</h3>
        <p class="text-muted small m-0">Transaksi dengan status "Baru" yang menunggu diambil customer.</p>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted">
                    <tr>
                        <th class="px-4 py-3 fw-semibold">No</th>
                        <th class="px-4 py-3 fw-semibold">Kode Order</th>
                        <th class="px-4 py-3 fw-semibold">Customer</th>
                        <th class="px-4 py-3 fw-semibold">Tanggal Masuk</th>
                        <th class="px-4 py-3 fw-semibold">Total</th>
                        <th class="px-4 py-3 fw-semibold text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-4 py-3 text-muted">{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                            <td class="px-4 py-3 font-monospace fw-bold text-dark">{{ $order->order_code }}</td>
                            <td class="px-4 py-3 text-dark">{{ $order->customer->customer_name ?? 'Pelanggan Terhapus' }}</td>
                            <td class="px-4 py-3 text-muted">{{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d M Y') }}</td>
                            <td class="px-4 py-3 font-monospace fw-bold text-success">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-end">
                                <a href="{{ route('operator.pickup.create', $order->id) }}" class="btn btn-sm btn-primary px-3 rounded-2">
                                    📦 Proses Pengambilan
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-5 text-center text-muted">
                                Tidak ada laundry yang menunggu diambil. Semua sudah selesai 🎉
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