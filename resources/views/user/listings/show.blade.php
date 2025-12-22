<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Detail {{ ucfirst($type) }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('image/appkonkos.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    body {
     overflow-x: hidden;
    }


    .carousel-item {
        transition: transform 0.6s ease-in-out;
    }
    </style>
</head>

@php
    $galleryImages = collect([$primaryImage])
        ->merge($detailImages ?? [])
        ->filter()
        ->map(fn($img) => asset('storage/' . $img))
        ->values();

    $statusClass = ['tersedia' => 'is-available', 'tidak tersedia' => 'is-limited'][$status] ?? 'is-booked';
    $isAvailable = $status === 'tersedia';
    $authUser = Auth::user();

    $facilityIcon = fn($item) => 'bi-check-circle';

    $notesTitle = $notesTitle ?? 'Informasi';
    $hasIframe = $mapEmbed && str_contains($mapEmbed, '<iframe');
@endphp

<body>
    <div class="page-wrapper detail-page">
        @include('user.home.partials.navbar')

        <main class="detail-main">
            <section class="detail-hero">
                <div class="container detail-stack">
                    @if ($galleryImages->isNotEmpty())
                        @php
                            $carouselId = 'galleryCarousel-' . uniqid();
                        @endphp
                        <article class="detail-card detail-gallery-card" data-aos="fade-up">
                            <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="carousel">
                                @if ($galleryImages->count() > 1)
                                    <div class="carousel-indicators">
                                        @foreach ($galleryImages as $index => $image)
                                            <button type="button" data-bs-target="#{{ $carouselId }}"
                                                data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                                                aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                                aria-label="Slide {{ $index + 1 }}"></button>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="carousel-inner">
                                    @foreach ($galleryImages as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ $image }}" class="d-block w-100" alt="Galeri {{ $title }}">
                                        </div>
                                    @endforeach
                                </div>
                                @if ($galleryImages->count() > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                @endif
                            </div>
                        </article>
                    @endif

                    <article class="detail-card detail-summary" data-aos="fade-up" data-aos-delay="100">
                        <h1>{{ $title }}</h1>
                        <p class="detail-location">
                            <i class="bi bi-geo-alt"></i> {{ $location }}
                        </p>

                        <div class="detail-meta">
                            <span class="meta-pill">{{ $roomLabel }} : {{ $roomValue ?: '-' }}</span>
                            <span class="status-pill {{ $statusClass }}">{{ ucfirst($status) }}</span>
                        </div>

                        <div class="detail-price-card">
                            <div>
                                <p class="muted">Mulai dari</p>
                                <p class="price-display">Rp {{ number_format($price, 0, ',', '.') }}
                                    <span>{{ $priceUnit }}</span>
                                </p>
                            </div>
                        </div>

                    </article>
                </div>
            </section>

            <section class="section detail-section">
                <div class="container">
                    <div class="detail-content-grid">
                        <article class="detail-card" data-aos="fade-up" data-aos-delay="200">
                            <h2>Fasilitas {{ $type === 'kosan' ? 'Kosan' : 'Kontrakan' }}</h2>
                            @if (count($roomFacilities))
                                <ul class="facility-list">
                                    @foreach ($roomFacilities as $item)
                                        <li>
                                            <i class="bi {{ $facilityIcon($item) }}"></i>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="muted">Belum ada data fasilitas.</p>
                            @endif
                        </article>

                        <article class="detail-card"data-aos="fade-up" data-aos-delay="300">
                            <h2>Fasilitas Umum</h2>
                            @if (count($generalFacilities))
                                <ul class="facility-list">
                                    @foreach ($generalFacilities as $item)
                                        <li>
                                            <i class="bi {{ $facilityIcon($item) }}"></i>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="muted">Belum ada data fasilitas umum.</p>
                            @endif
                        </article>

                        <article class="detail-card" data-aos="fade-up" data-aos-delay="400">
                            <h2>{{ $notesTitle }}</h2>
                            @if (!empty($notes))
                                <ul class="rules-list">
                                    @foreach ($notes as $rule)
                                        <li>
                                            <i class="bi bi-exclamation-circle"></i>
                                            <span>{{ $rule }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="muted">Belum ada informasi tambahan.</p>
                            @endif
                        </article>

                        <article class="detail-card" data-aos="fade-up" data-aos-delay="500">
                            <h2>Lokasi</h2>
                            <div class="map-wrapper">
                                @if ($hasIframe)
                                    {!! $mapEmbed !!}
                                @elseif ($mapEmbed)
                                    <iframe src="{{ $mapEmbed }}" width="100%" height="100%" style="border:0;"
                                        allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                @else
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3969.859886782684!2d108.3175115757283!3d-6.486627063977413!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fdbdec955a857%3A0x953cfafb24396c8c!2sPoliteknik%20Negeri%20Indramayu!5e0!3m2!1sid!2sid!4v1707044383170!5m2!1sid!2sid"
                                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                @endif
                            </div>
                        </article>
                    </div>

                    <div class="detail-cta d-flex justify-content-center align-items-center gap-3" data-aos="zoom-in" data-aos-delay="600" data-aos-offset="0">
                        <a href="{{ route('home') }}" 
                            class="btn btn-secondary" 
                            style="width: 40%; min-width: 150px;">
                            Kembali
                        </a>
                        @if ($isAvailable)
                            @if (Auth::check())
                                @if ($type === 'kosan')
                                    <a href="{{ route('booking.create.kosan', request()->route('kosan')) }}" class="btn btn-primary"
                                        style="width: 40%; min-width: 150px;">Ajukan Booking</a>
                                @else
                                    <a href="{{ route('booking.create.kontrakan', request()->route('kontrakan')) }}"
                                        class="btn btn-primary" style="width: 40%; min-width: 150px;">Ajukan Booking</a>
                                @endif
                            @else
                                <button class="btn btn-primary" style="width: 40%; min-width: 150px" data-login-trigger>Ajukan Booking</button>
                            @endif
                        @else
                            <button class="btn btn-secondary" style="width: 40%; min-width: 150px" disabled>Tidak Tersedia</button>
                        @endif
                    </div>
                </div>
            </section>
        </main>

        @include('user.home.partials.footer')
    </div>

    @include('user.home.partials.login-modal')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
        duration: 800,
        once: true,
    });
    </script>
</html>
