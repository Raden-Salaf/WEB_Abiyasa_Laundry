<x-layout-app :title="'Dashboard Pimpinan'">

    <div class="mb-4">
        <h3 class="fw-bold text-dark">Halo, {{ auth()->user()->name }} 👋</h3>
        <p class="text-muted small">Berikut ringkasan performa penjualan laundry.</p>
    </div>

    {{-- Stat cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-success bg-gradient text-white p-4">
                <p class="text-white-50 m-0 small fw-semibold">Total Omzet</p>
                <h2 class="fw-bold my-2 font-monospace">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h2>
                <small class="text-white-50">akumulasi seluruh transaksi</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-primary bg-gradient text-white p-4">
                <p class="text-white-50 m-0 small fw-semibold">Total Transaksi</p>
                <h1 class="fw-bold my-2 font-monospace">{{ $totalTransaksi }}</h1>
                <small class="text-white-50">sepanjang waktu</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-danger bg-gradient text-white p-4">
                <p class="text-white-50 m-0 small fw-semibold">Transaksi Bulan Ini</p>
                <h1 class="fw-bold my-2 font-monospace">{{ $totalBulanIni }}</h1>
                <small class="text-white-50">{{ now()->translatedFormat('F Y') }}</small>
            </div>
        </div>
    </div>

    {{-- Link Laporan Card --}}
    <a href="{{ route('pimpinan.laporan.index') }}" class="card border bg-white shadow-sm rounded-4 p-4 text-decoration-none hover-card-laporan">
        <div class="d-flex align-items-center gap-3">
            <div class="fs-1">📊</div>
            <div>
                <h5 class="fw-bold text-dark mb-1">Lihat Laporan Penjualan Lengkap</h5>
                <p class="text-muted small m-0">Detail transaksi, filter tanggal, dan rincian per order</p>
            </div>
        </div>
    </a>

</x-layout-app>

<style>
.hover-card-laporan {
    transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
}
.hover-card-laporan:hover {
    transform: translateY(-2px);
    border-color: #0d6efd !important;
    box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.1)!important;
}
</style>