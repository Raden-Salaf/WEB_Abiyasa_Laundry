<header class="navbar navbar-light bg-white border-bottom px-4 py-3 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-link link-dark p-0 d-lg-none" id="sidebar-toggle" aria-label="Toggle Sidebar" style="text-decoration: none;">
            <span class="fs-3">☰</span>
        </button>
        <div>
            <h5 class="m-0 fw-bold text-dark">{{ $title ?? 'Dashboard' }}</h5>
            <small id="topbar-clock" class="text-muted font-monospace mt-1 d-block" style="font-size: 0.75rem;">Memuat waktu...</small>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <div class="position-relative">
            <div class="rounded-circle bg-danger bg-gradient d-flex align-items-center justify-content-center text-white fw-bold" style="width: 40px; height: 40px; font-size: 0.9rem;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <span class="position-absolute bottom-0 end-0 bg-success border border-white border-2 rounded-circle" style="width: 12px; height: 12px;"></span>
        </div>
        <div class="d-none d-sm-block">
            <h6 class="m-0 fw-bold text-dark" style="font-size: 0.875rem; line-height: 1.2;">{{ auth()->user()->name }}</h6>
            <small class="text-muted d-block" style="font-size: 0.75rem;">{{ auth()->user()->level->level_name }}</small>
        </div>
    </div>
</header>

<script>
    function updateTopbarClock() {
        const now = new Date();
        const formatted = now.toLocaleDateString('id-ID', {
            weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
        }) + ' • ' + now.toLocaleTimeString('id-ID');

        const el = document.getElementById('topbar-clock');
        if (el) el.textContent = formatted;
    }

    updateTopbarClock();
    setInterval(updateTopbarClock, 1000);
</script>