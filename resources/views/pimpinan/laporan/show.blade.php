<x-layout-app :title="'Detail Transaksi'">

    {{-- Load Bootstrap 5 CDN khusus di halaman ini saja, tidak memengaruhi halaman lain --}}
    @push('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    @endpush

    <div class="mb-4">
        {{-- Link kembali ke halaman laporan --}}
        <a href="{{ route('pimpinan.laporan.index') }}" class="text-decoration-none text-secondary small">
            &larr; Kembali ke Laporan
        </a>

        {{-- Card header: kode order + badge status pengambilan & status pembayaran --}}
        <div class="card border-0 shadow-sm rounded-4 mt-3">
            <div class="card-body d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <div>
                    <h2 class="fw-bold mb-1">{{ $order->order_code }}</h2>
                    <p class="text-secondary small mb-0">Detail transaksi customer, status pengambilan, dan status pembayaran.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    {{-- Badge status pengambilan: kuning = baru (status 0), hijau = sudah diambil (status 1) --}}
                    @if ($order->order_status == 0)
                        <span class="badge rounded-pill text-bg-warning px-3 py-2">Baru</span>
                    @else
                        <span class="badge rounded-pill text-bg-success px-3 py-2">Sudah Diambil</span>
                    @endif

                    {{-- Badge status pembayaran: hijau solid = lunas, kuning = belum dibayar --}}
                    @if ($order->order_pay > 0)
                        <span class="badge rounded-pill text-bg-success px-3 py-2">Lunas</span>
                    @else
                        <span class="badge rounded-pill text-bg-warning px-3 py-2">Belum Dibayar</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Kolom kiri: info customer + rincian jasa --}}
        <div class="col-xl-8">

            {{-- Kartu info customer --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                        <div>
                            <h5 class="fw-semibold mb-1">Info Customer</h5>
                            <p class="text-secondary small mb-0">Informasi pelanggan dan tanggal transaksi.</p>
                        </div>
                        <span class="badge rounded-pill text-bg-primary px-3 py-2">
                            Order dibuat pada {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}
                        </span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 col-lg-4">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <p class="text-secondary small mb-1">Nama</p>
                                <p class="fw-medium mb-0">{{ $order->customer->customer_name ?? 'Pelanggan Terhapus' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <p class="text-secondary small mb-1">Telepon</p>
                                <p class="fw-medium mb-0">{{ $order->customer->phone ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <p class="text-secondary small mb-1">Alamat</p>
                                <p class="fw-medium mb-0">{{ $order->customer->address ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <p class="text-secondary small mb-1">Tanggal Masuk</p>
                                <p class="fw-medium mb-0">
                                    {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="bg-light rounded-3 p-3 h-100">
                                <p class="text-secondary small mb-1">Tanggal Selesai</p>
                                <p class="fw-medium mb-0">
                                    {{ $order->order_end_date ? \Carbon\Carbon::parse($order->order_end_date)->translatedFormat('d F Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu rincian jasa --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="fw-semibold mb-1">Rincian Jasa</h5>
                    <p class="text-secondary small mb-0">Semua item layanan yang termasuk di transaksi ini.</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-3">Jasa</th>
                                <th>Qty</th>
                                <th>Harga/kg</th>
                                <th>Subtotal</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Loop setiap detail jasa yang tersimpan di transaksi ini --}}
                            @foreach ($order->details as $detail)
                                <tr>
                                    <td class="px-3 fw-medium">{{ $detail->service->service_name }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td class="font-monospace">Rp {{ number_format($detail->service->price, 0, ',', '.') }}</td>
                                    <td class="font-monospace fw-semibold text-success">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    <td class="text-secondary">{{ $detail->notes ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Kolom kanan: ringkasan pembayaran + catatan --}}
        <div class="col-xl-4">

            {{-- Kartu ringkasan pembayaran, warna gradient sebagai penekanan visual --}}
            <div class="card border-0 shadow-lg rounded-4 mb-4 text-white" style="background: linear-gradient(135deg, #2D8CFF, #17B8A6);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <p class="small text-uppercase mb-2" style="letter-spacing: .15em; opacity: .8;">Ringkasan Pembayaran</p>
                            <h3 class="fw-bold mb-0">Rp {{ number_format($order->total, 0, ',', '.') }}</h3>
                        </div>
                        <span class="badge rounded-pill bg-white bg-opacity-25 text-white text-uppercase small px-3 py-2">
                            {{ $order->order_pay > 0 ? 'Selesai' : 'Belum Bayar' }}
                        </span>
                    </div>

                    <hr class="border-white border-opacity-25 my-3">

                    <div class="d-flex justify-content-between small mb-2">
                        <span class="opacity-75">Total Bayar</span>
                        <span class="fw-medium">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between small mb-2">
                        <span class="opacity-75">Dibayar</span>
                        <span class="fw-medium">{{ $order->order_pay > 0 ? 'Rp ' . number_format($order->order_pay, 0, ',', '.') : '-' }}</span>
                    </div>
                    <div class="d-flex justify-content-between small">
                        <span class="opacity-75">Kembalian</span>
                        <span class="fw-medium">{{ $order->order_change > 0 ? 'Rp ' . number_format($order->order_change, 0, ',', '.') : '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Kartu catatan tambahan --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-semibold mb-2">Catatan</h5>
                    <p class="text-secondary small mb-0" style="line-height: 1.6;">
                        Gunakan halaman ini untuk meninjau detail transaksi, status pengambilan, dan status pembayaran.
                        Pastikan pembayaran telah diproses sebelum menandai transaksi sebagai selesai.
                    </p>
                </div>
            </div>
        </div>
    </div>

</x-layout-app>