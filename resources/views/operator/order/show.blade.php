<x-layout-app :title="'Detail Transaksi'">

    <div class="mb-4">
        <a href="{{ route('operator.order.index') }}" class="text-decoration-none text-muted small">&larr; Kembali ke
            Transaksi Laundry</a>
        <div class="d-flex align-items-center gap-3 mt-2">
            <h3 class="fw-bold text-dark m-0">{{ $order->order_code }}</h3>
            @if ($order->order_status == 0)
                <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-semibold text-xs">Baru</span>
            @else
                <span class="badge bg-success text-white px-3 py-1.5 rounded-pill fw-semibold text-xs">Sudah Diambil</span>
            @endif
            @if ($order->order_pay > 0)
                <span class="badge bg-success text-white px-3 py-1.5 rounded-pill fw-semibold text-xs">Lunas</span>
            @else
                <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-semibold text-xs">Belum Dibayar</span>
            @endif
        </div>
    </div>

    {{-- Info customer --}}
    <div class="card shadow-sm border-0 rounded-4 p-4 mb-4 bg-white">
        <h5 class="fw-bold text-dark mb-3">Info Customer</h5>
        <div class="row g-3 text-sm">
            <div class="col-md-4">
                <span class="text-muted small d-block">Nama</span>
                <span class="fw-bold text-dark">{{ $order->customer->customer_name ?? 'Pelanggan Terhapus' }}</span>
            </div>
            <div class="col-md-4">
                <span class="text-muted small d-block">Telepon</span>
                <span class="fw-bold text-dark font-monospace">{{ $order->customer->phone ?? '-' }}</span>
            </div>
            <div class="col-md-4">
                <span class="text-muted small d-block">Tanggal Masuk</span>
                <span
                    class="fw-bold text-dark">{{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}</span>
            </div>
        </div>
    </div>

    {{-- Rincian jasa --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted">
                    <tr>
                        <th class="px-4 py-3 fw-semibold">Jasa</th>
                        <th class="px-4 py-3 fw-semibold">Qty (kg)</th>
                        <th class="px-4 py-3 fw-semibold">Harga/kg</th>
                        <th class="px-4 py-3 fw-semibold">Subtotal</th>
                        <th class="px-4 py-3 fw-semibold">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->details as $detail)
                        <tr>
                            <td class="px-4 py-3 fw-bold text-dark">{{ $detail->service->service_name }}</td>
                            <td class="px-4 py-3 text-dark">{{ $detail->qty }}</td>
                            <td class="px-4 py-3 text-muted font-monospace">Rp
                                {{ number_format($detail->service->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 font-monospace fw-bold text-success">Rp
                                {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-muted">{{ $detail->notes ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Kartu total bayar --}}
    <div class="card shadow-sm border-0 rounded-4 bg-primary bg-gradient text-white p-4 max-w-sm ms-auto"
        style="max-width: 320px;">
        <div class="d-flex justify-content-between align-items-center">
            <span class="fw-semibold text-white-50">Total Bayar</span>
            <span class="font-monospace fs-4 fw-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
        </div>
    </div>

</x-layout-app>