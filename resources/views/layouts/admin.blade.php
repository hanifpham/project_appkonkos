<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin APPKONKOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="icon" href="{{ asset('image/appkonkos.png') }}">
</head>

<body>
    <div class="mobile-header d-flex align-items-center px-3 gap-3">
        <button id="toggleSidebar" class="btn btn-primary d-lg-none"
            style="position: fixed; top: 10px; left: 15px; z-index: 2000; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
            <i class="bi bi-list fs-7"></i>
        </button>
    </div>

    <div class="sidebar">
        <div>
            <div class="brand px-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('image/appkonkos.png') }}" alt="Logo" width="50">
                    <div class="text-start">
                        <h5 class="fw-bold text-white mb-0">APPKONKOS</h5>
                        <small class="brand-subtext" style="font-size: 10px;">Pencarian Kos & Kontrakan</small>
                    </div>
                </div>
            </div>
            <nav class="nav flex-column mt-2">
                <a href="/admin/dashboard" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <i class="bi-house-door-fill"></i> Dashboard
                </a>
                <a href="/admin/kosan" class="nav-link {{ Request::is('admin/kosan*') ? 'active' : '' }}">
                    <i class="bi-journal-text"></i> Data Kosan
                </a>
                <a href="/admin/kontrakan" class="nav-link {{ Request::is('admin/kontrakan*') ? 'active' : '' }}">
                    <i class="bi-journal-richtext"></i> Data Kontrakan
                </a>
                <a href="/admin/booking" class="nav-link {{ Request::is('admin/booking*') ? 'active' : '' }}">
                    <i class="bi-calendar-week"></i> Data Booking
                </a>
                <a href="/admin/users" class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}">
                    <i class="bi-people"></i> Data Users
                </a>
                <a href="/admin/messages" class="nav-link {{ Request::is('admin/messages*') ? 'active' : '' }}">
                    <i class="bi-envelope-fill"></i> Pesan Masuk
                </a>
            </nav>
        </div>

        <div class="sidebar-bottom p-3">
            <!-- USER INFO -->
            <div class="d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-person-circle fs-3"></i>
                <div class="text-start overflow-hidden">
                    @auth
                        <b class="d-block text-truncate" style="max-width: 150px;">
                            {{ Auth::user()->nama }}
                        </b>
                        <small class="d-block text-truncate">
                            {{ Auth::user()->email }}
                        </small>
                    @endauth
                </div>
            </div>

            <!-- LOGOUT -->
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="button" onclick="confirmLogout()"
                    class="btn btn-danger btn-sm w-100 fw-semibold d-flex align-items-center justify-content-center gap-2 logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Log out
                </button>
            </form>
        </div>

    </div>

    <div class="sidebar-overlay" id="overlay"></div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 500,
            once: true
        });

        function confirmLogout() {
            Swal.fire({
                title: 'Yakin ingin logout?',
                text: 'Anda akan keluar dari akun admin.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        const btn = document.getElementById('toggleSidebar');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('overlay');

        function toggleMenu() {
            sidebar.classList.toggle('active');
        }

        if (btn) btn.addEventListener('click', toggleMenu);
        if (overlay) overlay.addEventListener('click', toggleMenu);

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: '{{ session('error') }}'
            });
        @endif
    </script>
</body>

</html>
