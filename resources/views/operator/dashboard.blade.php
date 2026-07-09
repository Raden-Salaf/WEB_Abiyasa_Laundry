<x-layout-app :title="'Dashboard Operator'">

    <div class="mb-4">
        <h3 class="fw-bold text-dark">Halo, {{ auth()->user()->name }} 👋</h3>
        <p class="text-muted small">Berikut ringkasan aktivitas laundry hari ini.</p>
    </div>

    {{-- Stat cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-primary bg-gradient text-white p-4">
                <p class="text-white-50 m-0 small fw-semibold">Transaksi Hari Ini</p>
                <h1 class="fw-bold my-2 font-monospace">{{ $totalHariIni }}</h1>
                <small class="text-white-50">order masuk hari ini</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-warning bg-gradient text-dark p-4">
                <p class="text-dark-50 m-0 small fw-semibold text-muted">Menunggu Diambil</p>
                <h1 class="fw-bold my-2 font-monospace">{{ $totalMenunggu }}</h1>
                <small class="text-dark-50 text-muted">laundry belum diambil</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-success bg-gradient text-white p-4">
                <p class="text-white-50 m-0 small fw-semibold">Sudah Selesai</p>
                <h1 class="fw-bold my-2 font-monospace">{{ $totalSelesai }}</h1>
                <small class="text-white-50">laundry sudah diambil</small>
            </div>
        </div>
    </div>

    {{-- Quick Action Cards --}}
    <div class="row g-3">
        <div class="col-md-6">
            <a href="{{ route('operator.order.create') }}" class="card bg-primary bg-gradient text-white border-0 shadow-sm rounded-4 p-4 text-decoration-none hover-card">
                <div class="fs-1 mb-2">🧾</div>
                <h5 class="fw-bold mb-1">Buat Transaksi Baru</h5>
                <p class="text-white-50 small m-0">Input customer & pilih jasa laundry</p>
            </a>
        </div>

        <div class="col-md-6">
            <a href="{{ route('operator.pickup.index') }}" class="card bg-white border shadow-sm rounded-4 p-4 text-decoration-none hover-card">
                <div class="fs-1 mb-2">📦</div>
                <h5 class="fw-bold text-dark mb-1">Proses Pengambilan</h5>
                <p class="text-muted small m-0">Lihat laundry yang siap diambil</p>
            </a>
        </div>
    </div>

</x-layout-app>

<style>
.hover-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.15)!important;
}
</style>