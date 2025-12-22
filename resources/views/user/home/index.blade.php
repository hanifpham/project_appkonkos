<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Apkonkos membantu Anda menemukan kos dan kontrakan terbaik dengan desain modern dan informatif.">
    <title>Appkonkos | Temukan Kos & Kontrakan Impian</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="{{ asset('image/appkonkos.png') }}">
    @vite(['resources/css/app.css','resources/css/responsive.css', 'resources/js/app.js'])
</head>

<body>
    @php
        $filters = $filters ?? [
            'lokasi' => request('lokasi'),
            'jenis' => request('jenis', 'semua'),
            'harga' => request('harga'),
        ];
        $selectedJenis = $filters['jenis'] ?? 'semua';
        $hasActiveFilters = ($filters['lokasi'] ?? false) || $selectedJenis !== 'semua' || ($filters['harga'] ?? false);
    @endphp
    <div class="page-wrapper">
        @include('user.home.partials.navbar')

        <main>
            <section id="hero" class="hero" style="background-image: url('{{ asset('image/hero.png') }}');">
                <div class="hero-overlay"></div>
                <div class="container hero-content">
                    <p class="hero-badge" data-aos="fade-up" data-aos-duration="1000"><i class="bi bi-star-fill"></i>
                        Platform Kos & Kontrakan Terpercaya</p>
                    <h1 class="hero-title">
                            Temukan Tempat Tinggal Sementara
                        <span class="span" style="display: block; color: #your-color;" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="400">
                            Impian Anda!
                        </span>
                    </h1>
                    <p class="hero-description" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                        Cari dan temukan pilihan kos-kosan dan kontrakan terbaik dengan fasilitas lengkap,
                        lokasi strategis, dan harga terjangkau di berbagai kota di Indonesia.
                    </p>
                    <div class="hero-actions" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
                        @auth
                            <a href="#discover" class="btn btn-primary">Booking Sekarang</a>
                            <a href="#contracts" class="btn btn-outline">Lihat Pilihan</a>
                        @else
                            <button class="btn btn-primary" data-login-trigger>Booking Sekarang</button>
                            <a href="#discover" class="btn btn-outline">Lihat Pilihan</a>
                        @endauth
                    </div>
                    <div class="search-panel" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1000">
                        <p class="search-panel-title">Cari kosan atau kontrakan sesuai kebutuhan Anda</p>
                        <form class="search-grid" method="GET" action="{{ route('home') }}" data-search-form
                            data-reset-url="{{ route('home') }}">
                            <label class="search-field">
                                <span>Lokasi</span>
                                <input type="text" name="lokasi" placeholder="Cari lokasi atau alamat"
                                    value="{{ $filters['lokasi'] ?? request('lokasi') }}">
                            </label>
                            <label class="search-field search-select-field">
                                <span>Jenis Hunian</span>
                                <div class="select-wrapper">
                                    <select name="jenis" class="search-select">
                                        <option value="semua"
                                            {{ ($filters['jenis'] ?? request('jenis', 'semua')) === 'semua' ? 'selected' : '' }}>
                                            Semua</option>
                                        <option value="kosan"
                                            {{ ($filters['jenis'] ?? request('jenis')) === 'kosan' ? 'selected' : '' }}>
                                            Kosan</option>
                                        <option value="kontrakan"
                                            {{ ($filters['jenis'] ?? request('jenis')) === 'kontrakan' ? 'selected' : '' }}>
                                            Kontrakan</option>
                                    </select>
                                </div>
                            </label>
                            <label class="search-field">
                                <span>Harga</span>
                                <input type="text" name="harga" placeholder="Range harga"
                                    value="{{ $filters['harga'] ?? request('harga') }}">
                            </label>
                            <button type="submit" class="btn btn-primary full-btn">
                                <i class="bi bi-search"></i> Cari Kos dan Kontrakan
                            </button>
                        </form>
                        @if ($hasActiveFilters)
                            <a class="search-reset-link" href="{{ route('home') }}">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset pencarian
                            </a>
                        @endif
                    </div>
                </div>
            </section>

            @if ($selectedJenis !== 'kontrakan')
                <section id="discover" class="section">
                    <div class="container" data-aos="fade-up">
                        <div class="section-heading">
                            <p>Kos - kosan Pilihan</p>
                            <h2>Temukan berbagai pilihan kos terbaik untuk kebutuhan Anda</h2>
                        </div>

                        <div class="card-grid" data-aos="fade-up" id="discover">
                            @forelse ($kosans as $index => $item)
                                @php
                                    $image = $item->gambar_kosan
                                        ? asset('storage/' . $item->gambar_kosan)
                                        : 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=900&q=80';
                                    $detailUrl = route('kosan.detail', $item);
                                    $delay = ($index % 4) * 200;
                                @endphp
                                <article class="listing-card" onclick="window.location='{{ $detailUrl }}'" data-aos="fade-up" data-aos-delay="{{$delay}}">
                                    <div class="listing-image" style="background-image: url('{{ $image }}');">
                                        <span
                                            class="badge-status {{ $item->status === 'tersedia' ? 'is-available' : 'is-unavailable' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>
                                    <div class="listing-body">
                                        <h3>{{ $item->nama_kosan }}</h3>
                                        <p class="listing-address">
                                            <i class="bi bi-geo-alt"></i>
                                            {{ \Illuminate\Support\Str::limit($item->alamat, 80) }}
                                        </p>
                                        <p class="listing-price">Rp
                                            {{ number_format($item->harga_bulan, 0, ',', '.') }} / Bulan
                                        </p>
                                        <a class="btn btn-outline" href="{{ $detailUrl }}">Lihat Detail</a>
                                    </div>
                                </article>
                            @empty
                                <p class="empty-state">
                                    {{ $hasActiveFilters ? 'Tidak ada kosan yang cocok dengan pencarian.' : 'Belum ada data kosan yang tersedia.' }}
                                </p>
                            @endforelse
                        </div>
                    </div>
                </section>
            @endif

            @if ($selectedJenis !== 'kosan')
                <section class="section" id="contracts">
                    <div class="container" data-aos="fade-up">
                        <div class="section-heading">
                            <p>Kontrakan Pilihan</p>
                            <h2>Temukan berbagai pilihan kontrakan terbaik untuk kebutuhan Anda</h2>
                        </div>

                        <div class="card-grid" data-aos="fade-up">
                            @forelse ($kontrakans as $index => $item)
                                @php
                                    $image = $item->gambar_kontrakan
                                        ? asset('storage/' . $item->gambar_kontrakan)
                                        : 'https://images.unsplash.com/photo-1434434319959-1f886517e1fe?auto=format&fit=crop&w=900&q=80';
                                    $detailUrl = route('kontrakan.detail', $item);
                                    $delay = ($index % 4) * 200;
                                @endphp
                                <article class="listing-card" onclick="window.location='{{ $detailUrl }}'" data-aos="fade-up" data-aos-delay="{{$delay}}">
                                    <div class="listing-image" style="background-image: url('{{ $image }}');">
                                        <span
                                            class="badge-status {{ $item->status === 'tersedia' ? 'is-available' : 'is-unavailable' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </div>
                                    <div class="listing-body">
                                        <h3>{{ $item->nama_kontrakan }}</h3>
                                        <p class="listing-address">
                                            <i class="bi bi-geo-alt"></i>
                                            {{ \Illuminate\Support\Str::limit($item->alamat, 80) }}
                                        </p>
                                        <p class="listing-price">Rp
                                            {{ number_format($item->harga_tahun, 0, ',', '.') }} / Tahun
                                        </p>
                                        <a class="btn btn-outline" href="{{ $detailUrl }}">Lihat Detail</a>
                                    </div>
                                </article>
                            @empty
                                <p class="empty-state">
                                    {{ $hasActiveFilters ? 'Tidak ada kontrakan yang cocok dengan pencarian.' : 'Belum ada data kontrakan yang tersedia.' }}
                                </p>
                            @endforelse
                        </div>
                    </div>
                </section>
            @endif

            <section id="contact" class="section contact-section">
                <div class="container">
                    <div class="section-heading" data-aos="fade-up" data-aos-duration="1000">
                        <p>Contact Us</p>
                        <h2>Punya pertanyaan atau masukan? Kirimkan pesan kepada kami!</h2>
                    </div>

                    <div class="contact-grid">
                        <div class="info-card" data-aos="fade-up" data-aos-delay="0">
                            <i class="bi bi-envelope-fill"></i>
                            <h4>Email</h4>
                            <p>apkonkos@gmail.com</p>
                        </div>
                        <div class="info-card" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-telephone-fill"></i>
                            <h4>Telepon</h4>
                            <p>+62 823-1697-9586</p>
                        </div>
                        <div class="info-card" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-geo-alt-fill"></i>
                            <h4>Alamat</h4>
                            <p>Jl. Raya Lohbener Lama No. 08, Indramayu</p>
                        </div>
                        <div class="info-card" data-aos="fade-up" data-aos-delay="600">
                            <i class="bi bi-clock-fill"></i>
                            <h4>Jam Operasional</h4>
                            <p>Senin - Jumat 08:00 - 18:00</p>
                            <p>Sabtu 09:00 - 15:00</p>
                        </div>
                    </div>

                    <div class="contact-content">
                        <div class="contact-form" data-aos="fade-right" data-aos-duration="1000">
                            <h3>Kirim Pesan</h3>
                            <form method="POST" action="{{ route('contact-messages.store') }}">
                                @csrf
                                <label>
                                    Masukkan Nama :
                                    <input type="text" name="nama" placeholder="Masukkan nama anda"
                                        value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </label>
                                <label>
                                    Masukkan Email :
                                    <input type="email" name="email" placeholder="Masukkan email anda"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </label>
                                <label>
                                    Tulis Pesan :
                                    <textarea name="pesan" rows="3" placeholder="Keluhan atau masukan" required>{{ old('pesan') }}</textarea>
                                    @error('pesan')
                                        <small class="form-error">{{ $message }}</small>
                                    @enderror
                                </label>
                                <button type="submit" class="btn btn-primary full-btn">Kirim Pesan</button>
                            </form>
                        </div>

                        <div class="contact-map" data-aos="fade-left" data-aos-duration="1000">
                            <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1675.4583272395553!2d108.28095288843033!3d-6.408621461776797!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6eb87d1fcaf97d%3A0x4fc15b3c8407ada4!2sPoliteknik%20Negeri%20Indramayu!5e1!3m2!1sid!2sid!4v1766039412169!5m2!1sid!2sid" 
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        </div>
                    </div>

                    <div class="social-card" data-aos="zoom-in" data-aos-duration="800">
                        <div>
                            <h4>Ikuti Kami</h4>
                            <p>Dapatkan update terbaru tentang Kosan/Kontrakan dan promo menarik</p>
                        </div>
                        <div class="social-links">
                            <a href="https://www.instagram.com/haaniff.pham?igsh=MTVjNWZwdzE2a2F3Yw==" data-aos="fade-up" data-aos-delay="300" target="_blank"
                                rel="noreferrer">
                                <i class="bi bi-instagram"></i> @Appkonkos
                            </a>
                            <a href="https://facebook.com" data-aos="fade-up" data-aos-delay="500" target="_blank" rel="noreferrer">
                                <i class="bi bi-facebook"></i> @Appkonkos
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('user.home.partials.footer')
    </div>

    @include('user.home.partials.login-modal')
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Script untuk SweetAlert dari session -->
<script>
    AOS.init({
        duration: 900,
        once: true,
    });
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        })
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '{{ session('error') }}',
            showConfirmButton: true
        })
    @endif
</script>

</html>
