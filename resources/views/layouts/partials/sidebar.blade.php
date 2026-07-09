@php
    $level = auth()->user()->level->level_name;
@endphp

<aside class="sidebar-wrapper bg-info d-flex flex-column text-white shadow">

    {{-- Brand --}}
    <div class="px-4 py-4 d-flex align-items-center gap-3 border-bottom border-white border-opacity-10">
        <div class="rounded-3 bg-primary bg-gradient d-flex align-items-center justify-content-center"
            style="width: 40px; height: 40px;">
            <img src="{{ asset('img/Paijo Laundry.png') }}" alt="Paijo Laundry" class="sidebar-brand-logo">
        </div>
        <div>
            <h6 class="m-0 fw-bold leading-tight text-white">Paijo Laundry</h6>
            <small class="text-white-50 text-xs">{{ $level }} Panel</small>
        </div>
    </div>

    {{-- Menu navigasi --}}
    <nav class="flex-grow-1 px-3 py-4">
        <div class="nav nav-pills flex-column gap-1">

            @if ($level === 'Administrator')
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link text-white d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : 'opacity-75' }}">
                    <span>🏠</span> <span class="fw-medium text-sm">Dashboard</span>
                </a>
                <a href="{{ route('admin.customer.index') }}"
                    class="nav-link text-white d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('admin.customer.*') ? 'active bg-primary' : 'opacity-75' }}">
                    <span>🦧</span> <span class="fw-medium text-sm">Customer</span>
                </a>
                <a href="{{ route('admin.user.index') }}"
                    class="nav-link text-white d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('admin.user.*') ? 'active bg-primary' : 'opacity-75' }}">
                    <span>👳‍♂️</span> <span class="fw-medium text-sm">User</span>
                </a>
                <a href="{{ route('admin.service.index') }}"
                    class="nav-link text-white d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('admin.service.*') ? 'active bg-primary' : 'opacity-75' }}">
                    <span>🧺</span> <span class="fw-medium text-sm">Jenis Service</span>
                </a>

                {{-- Label pemisah section, menandakan menu di bawah bukan master data --}}
                <small class="d-block px-3 pt-3 pb-1 text-uppercase text-white-50"
                    style="font-size: 10px; letter-spacing: .08em;">
                    Operasional
                </small>

                {{-- Menu Operator, ikut ditampilkan untuk Administrator supaya bisa langsung pakai --}}
                <a href="{{ route('operator.order.index') }}"
                    class="nav-link text-white d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('operator.order.*') ? 'active bg-primary' : 'opacity-75' }}">
                    <span>🧾</span> <span class="fw-medium text-sm">Transaksi Laundry</span>
                </a>
                <a href="{{ route('operator.pickup.index') }}"
                    class="nav-link text-white d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('operator.pickup.*') ? 'active bg-primary' : 'opacity-75' }}">
                    <span>📦</span> <span class="fw-medium text-sm">Pengambilan Laundry</span>
                </a>

                {{-- Menu Pimpinan, ikut ditampilkan untuk Administrator supaya bisa langsung pakai --}}
                <a href="{{ route('pimpinan.laporan.index') }}"
                    class="nav-link text-white d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('pimpinan.laporan.*') ? 'active bg-primary' : 'opacity-75' }}">
                    <span>📊</span> <span class="fw-medium text-sm">Laporan Penjualan</span>
                </a>
            @endif

            @if ($level === 'Operator')
                <a href="{{ route('operator.dashboard') }}"
                    class="nav-link text-white d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('operator.dashboard') ? 'active bg-primary' : 'opacity-75' }}">
                    <span>🏠</span> <span class="fw-medium text-sm">Dashboard</span>
                </a>
                {{-- <a href="{{ route('operator.customer.index') }}"
                    class="nav-link text-white d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('operator.customer.*') ? 'active bg-primary' : 'opacity-75' }}">
                    <span>🦧</span> <span class="fw-medium text-sm">Customer</span>
                </a> --}}
                <a href="{{ route('operator.order.index') }}"
                    class="nav-link text-white d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('operator.order.*') ? 'active bg-primary' : 'opacity-75' }}">
                    <span>🧾</span> <span class="fw-medium text-sm">Transaksi Laundry</span>
                </a>
                <a href="{{ route('operator.pickup.index') }}"
                    class="nav-link text-white d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('operator.pickup.*') ? 'active bg-primary' : 'opacity-75' }}">
                    <span>📦</span> <span class="fw-medium text-sm">Pengambilan</span>
                </a>
            @endif

            @if ($level === 'Pimpinan')
                <a href="{{ route('pimpinan.dashboard') }}"
                    class="nav-link text-white d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('pimpinan.dashboard') ? 'active bg-primary' : 'opacity-75' }}">
                    <span>🏠</span> <span class="fw-medium text-sm">Dashboard</span>
                </a>
                <a href="{{ route('pimpinan.laporan.index') }}"
                    class="nav-link text-white d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ request()->routeIs('pimpinan.laporan.*') ? 'active bg-primary' : 'opacity-75' }}">
                    <span>📊</span> <span class="fw-medium text-sm">Laporan Penjualan</span>
                </a>
            @endif
        </div>
    </nav>

    {{-- Logout --}}
    <div class="p-3 border-top border-white border-opacity-10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="btn btn-outline-danger w-full d-flex align-items-center  gap-2 py-2 text-white border-0 opacity-75 hover-bg-danger rounded-3"
                style="transition: all 0.2s;">
                <span>🚪</span> Logout
            </button>
        </form>
    </div>
</aside>

<style>
    .sidebar-wrapper .nav-link {
        transition: all 0.2s ease-in-out;
    }

    .sidebar-wrapper .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.08);
        opacity: 1 !important;
    }

    .sidebar-wrapper .nav-link.active {
        background-color: #0d6efd !important;
        opacity: 1 !important;
    }

    .sidebar-wrapper button.hover-bg-danger:hover {
        background-color: #dc3545 !important;
        color: #fff !important;
        opacity: 1 !important;
    }

    .sidebar-wrapper .nav-link {
        transition: all 0.2s ease-in-out;
    }

    .sidebar-wrapper .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.08);
        opacity: 1 !important;
    }

    .sidebar-wrapper .nav-link.active {
        background-color: #0d6efd !important;
        opacity: 1 !important;
    }

    .sidebar-wrapper button.hover-bg-danger:hover {
        background-color: #dc3545 !important;
        color: #fff !important;
        opacity: 1 !important;
    }

    .sidebar-brand-logo,
    .login-brand-logo {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .text-xs {
        font-size: 0.75rem;
    }

    .text-sm {
        font-size: 0.875rem;
    }

    .w-full {
        width: 100%;
    }
</style>