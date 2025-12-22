<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Booking - {{ ucfirst($type) }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('image/appkonkos.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php
    $user = Auth::user();
    $title = $type === 'kosan' ? $listing->nama_kosan : $listing->nama_kontrakan;
    $location = $listing->alamat;
    $status = $listing->status;
    $statusClass = ['tersedia' => 'is-available', 'tidak tersedia' => 'is-limited'][$status] ?? 'is-booked';
@endphp

<body>
    <div class="page-wrapper detail-page">
        @include('user.home.partials.navbar')

        <main class="detail-main">
            <section class="section detail-section">
                <div class="container">

                    <div class="d-flex flex-column gap-4">
                        <article class="detail-card" data-aos="fade-down">
                            <div class="booking-cover mb-4">
                                <img src="{{ asset('storage/' . ($listing->gambar_kosan ?? $listing->gambar_kontrakan)) }}"
                                    class="w-100 h-100" alt="{{ $title }}">
                            </div>
                            <h2 class="mb-1">{{ $title }}</h2>
                            <p class="detail-location mb-2"><i class="bi bi-geo-alt"></i> {{ $location }}</p>
                            <div class="d-flex align-items-center gap-2">
                                <span class="meta-pill">{{ $type === 'kosan' ? 'Kamar' : 'Jumlah Kamar' }} :
                                    {{ $type === 'kosan' ? $listing->kamar_yang_tersedia : $listing->jumlah_kamar }}</span>
                                <span class="status-pill {{ $statusClass }}">{{ ucfirst($status) }}</span>
                            </div>
                        </article>

                        <article class="detail-card" data-aos="fade-up" data-aos-delay="200">
                            <p class="mb-4 text-uppercase fw-semibold text-muted">Pengajuan Booking</p>
                            <h2 class="mb-0">Informasi Penyewa</h2>
                            <p class="text-muted mb-3">Lengkapi data berikut untuk mengajukan booking.</p>

                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('booking.store') }}" method="POST" class="row g-3">
                                @csrf
                                @if ($type === 'kosan')
                                    <input type="hidden" name="kosan_id" value="{{ $listing->id }}">
                                @else
                                    <input type="hidden" name="kontrakan_id" value="{{ $listing->id }}">
                                @endif

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $user->nama }}" disabled>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nomor Telepon <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="telepon" class="form-control" placeholder="081-234-567-891"
                                        value="{{ old('telepon', $user->telepon) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Estimasi Total Biaya</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" id="display_total" class="form-control fw-bold"
                                            value="{{ number_format($price, 0, ',', '.') }}" readonly>
                                        <span class="input-group-text" id="display_unit">{{ $priceUnit }}</span>
                                    </div>
                                    <small class="text-muted">*Total otomatis berubah sesuai tanggal.</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Mulai Sewa <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_mulai" class="form-control"
                                        value="{{ old('tanggal_mulai') }}" min="{{ now()->toDateString() }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Selesai Sewa <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_selesai" class="form-control"
                                        value="{{ old('tanggal_selesai') }}" min="{{ now()->toDateString() }}" required>
                                </div>

                                <div class="col-12 d-flex justify-content-center align-items-center gap-3 mt-4">
                                    <a href="{{ $type === 'kosan' ? route('kosan.detail', $listing) : route('kontrakan.detail', $listing) }}"
                                        class="btn btn-secondary px-5" style="min-width: 200px;" data-aos="fade-up"
                                        data-aos-delay="400">Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary px-5" data-aos="zoom-in"
                                        data-aos-delay="500">Ajukan Booking
                                    </button>
                                </div>
                            </form>
                        </article>
                    </div>
                </div>
            </section>
        </main>

        @include('user.home.partials.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>

        AOS.init({
            duration: 800,
            once: true,
        });

        document.addEventListener('DOMContentLoaded', function () {
            const tglMulai = document.querySelector('input[name="tanggal_mulai"]');
            const tglSelesai = document.querySelector('input[name="tanggal_selesai"]');
            const displayTotal = document.getElementById('display_total');
            const displayUnit = document.getElementById('display_unit');

            const hargaDasar = {{ $price }};
            const tipe = "{{ $type }}";

            function formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID').format(angka);
            }

            function hitungBiaya() {
                const start = new Date(tglMulai.value);
                const end = new Date(tglSelesai.value);

                if (tglMulai.value && tglSelesai.value && end > start) {
                    const diffTime = Math.abs(end - start);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    let durasi = 1;
                    let unitTeks = "";

                    if (tipe === 'kosan') {
                        durasi = Math.ceil(diffDays / 30);
                        if (durasi < 1) durasi = 1;
                        unitTeks = ` / ${durasi} Bulan`;
                    } else {
                        durasi = end.getFullYear() - start.getFullYear();
                        if (durasi < 1) durasi = 1;
                        unitTeks = ` / ${durasi} Tahun`;
                    }

                    const total = hargaDasar * durasi;
                    displayTotal.value = formatRupiah(total);
                    displayUnit.innerText = unitTeks;
                }
            }

            tglMulai.addEventListener('change', hitungBiaya);
            tglSelesai.addEventListener('change', hitungBiaya);
        });
    </script>
</body>

</html>