<x-layout-app :title="'Dashboard Administrator'">

    {{-- Sapaan --}}
    <div class="mb-4">
        <h3 class="fw-bold text-dark">Halo, {{ auth()->user()->name }}🐒 👋</h3>
        <p class="text-muted small">Berikut ringkasan master data laundry Anda hari ini.</p>
    </div>

    {{-- Stat cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-primary bg-gradient text-white p-4">
                <p class="text-white-50 m-0 small fw-semibold">Total Customer</p>
                <h1 class="fw-bold my-2 font-monospace">{{ $totalCustomer }}</h1>
                <small class="text-white-50">pelanggan terdaftar</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-success bg-gradient text-white p-4">
                <p class="text-white-50 m-0 small fw-semibold">Total User</p>
                <h1 class="fw-bold my-2 font-monospace">{{ $totalUser }}</h1>
                <small class="text-white-50">akun aktif (semua level)</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-danger bg-gradient text-white p-4">
                <p class="text-white-50 m-0 small fw-semibold">Jenis Service</p>
                <h1 class="fw-bold my-2 font-monospace">{{ $totalService }}</h1>
                <small class="text-white-50">jasa laundry tersedia</small>
            </div>
        </div>
    </div>

    {{-- Menu cepat ke master data --}}
    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
        <h5 class="fw-bold text-dark mb-3">Master Data</h5>

        <div class="row g-3">
            <div class="col-md-4">
                <a href="{{ route('admin.customer.index') }}"
                    class="card border h-100 text-decoration-none hover-bg-light transition rounded-3 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="fs-2 text-primary"> 🦧</div>
                        <div>
                            <h6 class="m-0 fw-bold text-primary">Customer</h6>
                            <small class="text-muted">Kelola data pelanggan</small>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('admin.user.index') }}"
                    class="card border h-100 text-decoration-none hover-bg-light transition rounded-3 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="fs-2">👳‍♂️</div>
                        <div>
                            <h6 class="m-0 fw-bold text-success">User</h6>
                            <small class="text-muted">Kelola akun operator</small>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('admin.service.index') }}"
                    class="card border h-100 text-decoration-none hover-bg-light transition rounded-3 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="fs-2 text-danger">🧺</div>
                        <div>
                            <h6 class="m-0 fw-bold text-danger">Jenis Service</h6>
                            <small class="text-muted">Kelola jasa & harga</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

</x-layout-app>

<style>
    .hover-bg-light {
        transition: all 0.2s ease-in-out;
    }

    .hover-bg-light:hover {
        background-color: #f8f9fa;
        border-color: #0d6efd !important;
    }
</style>
