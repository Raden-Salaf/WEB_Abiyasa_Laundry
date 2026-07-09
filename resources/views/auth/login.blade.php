<x-layout-guest :title="'Login - Sistem Informasi Laundry'">

    <div class="d-flex align-items-center justify-content-center min-vh-100 p-4"
        style="background: linear-gradient(135deg, #f4f8fc 0%, #e1e9f5 100%);">

        <div class="w-100" style="max-width: 400px;">

            {{-- Brand Mark --}}
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-white shadow-sm rounded-4 p-2 mb-3"
                    style="width: 80px; height: 80px; border-radius: 1rem;">
                    <img src="{{ asset('img/Paijo Laundry.png') }}" alt="Paijo Laundry"
                        style="max-width: 110%; max-height: 110%; object-fit: contain;">
                </div>
                <h3 class="fw-bold text-dark mb-1">Paijo Laundry</h3>
                <span class="fs-1">🐒</span>
                <p class="text-muted small">Sistem Informasi Laundry</p>
            </div>

            {{-- Login Card --}}
            <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">

                {{-- Realtime clock & date --}}
                <div class="text-center mb-4 pb-3 border-bottom border-dashed">
                    <h2 id="live-clock" class="font-monospace fw-bold text-dark m-0">--:--:--</h2>
                    <small id="live-date" class="text-muted">Memuat tanggal...</small>
                </div>

                <h5 class="fw-bold mb-3 text-dark text-center">Masuk ke akun Anda</h5>

                {{-- Tampilkan error login jika ada --}}
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 py-2 px-3 small mb-3">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="form-control rounded-3 py-2" placeholder="nama@laundry.com">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small fw-semibold">Password</label>
                        <input type="password" name="password" required class="form-control rounded-3 py-2"
                            placeholder="••••••••">
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2.5 rounded-3 fw-semibold">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const time = now.toLocaleTimeString('id-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const date = now.toLocaleDateString('id-US', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

            const clockEl = document.getElementById('live-clock');
            const dateEl = document.getElementById('live-date');
            if (clockEl) clockEl.textContent = time;
            if (dateEl) dateEl.textContent = date;
        }

        updateClock();
        setInterval(updateClock, 1000);
    </script>

</x-layout-guest>
