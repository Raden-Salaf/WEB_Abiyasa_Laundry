<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Sistem Informasi Laundry' }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
        }

        /* Layout structure */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling overrides / complements */
        .sidebar-wrapper {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            z-index: 1040;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Main Content container */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: calc(100% - 280px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .page-content {
            padding: 2rem;
            flex-grow: 1;
        }

        /* Sidebar Backdrop Overlay on Mobile */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 1030;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-backdrop.show {
            display: block;
            opacity: 1;
        }

        /* Responsive styling */
        @media (max-width: 991.98px) {
            .sidebar-wrapper {
                transform: translateX(-100%);
            }
            .sidebar-wrapper.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            .page-content {
                padding: 1.25rem;
            }
        }
    </style>
</head>
<body>

    <div class="app-container">
        <!-- Backdrop Overlay -->
        <div id="sidebar-backdrop" class="sidebar-backdrop"></div>

        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main Workspace -->
        <div class="main-content">
            <!-- Topbar Header -->
            @include('layouts.partials.topbar')

            <!-- Main Page Panel -->
            <main class="page-content">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('sidebar-toggle');
            const sidebar = document.querySelector('.sidebar-wrapper');
            const backdrop = document.getElementById('sidebar-backdrop');

            if (toggleBtn && sidebar && backdrop) {
                function toggleSidebar() {
                    const isOpen = sidebar.classList.contains('show');
                    if (isOpen) {
                        sidebar.classList.remove('show');
                        backdrop.classList.remove('show');
                        setTimeout(() => {
                            if (!sidebar.classList.contains('show')) {
                                backdrop.style.display = 'none';
                            }
                        }, 300);
                    } else {
                        backdrop.style.display = 'block';
                        // Force reflow
                        backdrop.offsetHeight;
                        sidebar.classList.add('show');
                        backdrop.classList.add('show');
                    }
                }

                toggleBtn.addEventListener('click', toggleSidebar);
                backdrop.addEventListener('click', toggleSidebar);
            }
        });
    </script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Global Session & Action Scripts (SweetAlert) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Alert Sukses dari Session
            @if(session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    timer: 2500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    background: '#ffffff',
                    color: '#1e293b',
                    iconColor: '#10b981',
                    customClass: {
                        popup: 'shadow-sm border rounded-4'
                    }
                });
            @endif

            // 2. Alert Error dari Session
            @if(session('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#3b82f6',
                    background: '#ffffff',
                    color: '#1e293b',
                    customClass: {
                        popup: 'shadow-sm border rounded-4'
                    }
                });
            @endif

            // 3. Konfirmasi Hapus untuk Formulir dengan Class .form-delete
            document.addEventListener('submit', function (e) {
                if (e.target && e.target.classList.contains('form-delete')) {
                    e.preventDefault();
                    const form = e.target;
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        background: '#ffffff',
                        color: '#1e293b',
                        customClass: {
                            popup: 'shadow-sm border rounded-4',
                            confirmButton: 'px-4 py-2 rounded-3',
                            cancelButton: 'px-4 py-2 rounded-3'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
