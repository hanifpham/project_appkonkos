<header class="site-header" id="top">
    <div class="container nav-container" data-aos="fade-down">
        <a href="{{ route('home') }}#top" class="brand">
            <img src="{{ asset('image/appkonkos.png') }}" alt="Appkonkos Logo">
            <div>
                <strong>Appkonkos</strong>
                <small>Stay Smart</small>
            </div>
        </a>

        <nav class="nav-links">
            <a href="{{ route('home') }}#hero">Home</a>
            <div class="nav-dropdown">
                <a class="dropdown-trigger">Cari Apa?<i class="bi bi-caret-down-fill"></i></a>
                <div class="dropdown-menu">
                    <a href="{{ route('home') }}#discover"><i class="bi-house-door-fill"> </i> Kos-Kosan</a>
                    <a href="{{ route('home') }}#contracts"><i class="bi-houses-fill"> </i> Kontrakan</a>
                </div>
            </div>
            <a href="{{ route('home') }}#contact">Contact Us</a>
        </nav>

        @auth
            <div class="nav-profile" data-profile-dropdown>
                <button class="profile-trigger" type="button" data-profile-trigger>
                    <span class="avatar">
                        <i class="bi bi-person-circle"></i>
                    </span>
                    <span class="profile-name">{{ Auth::user()->nama }}</span>
                </button>
                <div class="profile-menu" data-profile-menu>
                    <a href="{{ route('user.profile') }}">
                        <i class="bi bi-person-fill"></i> Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="nav-cta">
                <a href="{{ route('register.form') }}" class="btn btn-outline">Daftar</a>
                <button class="btn btn-primary" data-login-trigger>Masuk</button>
            </div>
        @endauth

    </div>
</header>

<nav class="bottom-nav">
    <a href="{{ route('home') }}#hero" aria-label="Beranda">
        <i class="bi bi-house-door-fill" aria-hidden="true"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('home') }}#discover" aria-label="Cari apa?">
        <i class="bi bi-search" aria-hidden="true"></i>
        <span>Cari Apa?</span>
    </a>
    <a href="{{ route('home') }}#contact" aria-label="Kontak">
        <i class="bi bi-chat-dots-fill" aria-hidden="true"></i>
        <span>Contact Us</span>
    </a>
</nav>