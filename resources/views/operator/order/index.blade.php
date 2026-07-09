<x-layout-app :title="'Transaksi Laundry'">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">Transaksi Laundry</h3>
            <p class="text-muted small m-0">Daftar seluruh transaksi laundry yang pernah dibuat.</p>
        </div>
        <a href="{{ route('operator.order.create') }}"
            class="btn btn-primary px-4 py-2 rounded-3 d-flex align-items-center gap-2">
            <span>+</span> Buat Transaksi Baru
        </a>
    </div>

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
                                <a href="{{ route('operator.order.show', $order->id) }}"
                                    class="btn btn-sm btn-outline-primary px-3 rounded-2">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-5 text-center text-muted">
                                Belum ada transaksi. Yuk buat yang pertama 🧾
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