<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya | Appkonkos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('image/appkonkos.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="profile-page">
    <div class="page-wrapper">
        @include('user.home.partials.navbar')

        <main class="profile-main">
            <div class="container profile-container">
                <header class="profile-heading" data-aos="fade-down" data-aos-duration="1000">
                    <h1>Profil saya</h1>
                    <p>Kelola informasi dan riwayat booking Anda</p>
                </header>

                @if (session('success'))
                    <div class="profile-alert success" data-aos="zoom-in">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="profile-alert error">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <span>Terjadi kesalahan. Silakan periksa kembali data Anda.</span>
                    </div>
                @endif

                <div class="profile-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="mb-4">
                        <a href="{{ route('home') }}"
                            class="btn btn-outline-secondary d-inline-flex align-items-center fw-bold">
                            <i class="bi bi-arrow-left me-2"></i>
                            Kembali
                        </a>
                    </div>
                    <div class="profile-tabs mb-3" data-profile-tabs>
                        <button class="tab-button is-active" type="button" data-tab-target="info">Informasi</button>
                        <button class="tab-button" type="button" data-tab-target="booking">Riwayat Booking</button>
                    </div>

                    <section class="tab-panel is-active" data-profile-panel="info">
                        <div class="panel-header">
                            <h2>Informasi Pribadi</h2>
                            <p>Update informasi pribadi Anda</p>
                        </div>

                        <form class="profile-form" method="POST" action="{{ route('user.profile.update') }}">
                            @csrf
                            @method('PUT')
                            <label class="form-field">
                                <span>Nama Lengkap</span>
                                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}"
                                    placeholder="Masukkan nama lengkap Anda">
                                @error('nama')
                                    <small class="input-error">{{ $message }}</small>
                                @enderror
                            </label>

                            <label class="form-field">
                                <span>Email</span>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    placeholder="Masukkan email aktif">
                                @error('email')
                                    <small class="input-error">{{ $message }}</small>
                                @enderror
                            </label>

                            <label class="form-field">
                                <span>Nomor Telepon</span>
                                <input type="text" name="telepon" value="{{ old('telepon', $user->telepon) }}"
                                    placeholder="081-234-567-891">
                                @error('telepon')
                                    <small class="input-error">{{ $message }}</small>
                                @enderror
                            </label>
                            <button type="submit" class="btn btn-primary full-btn">Simpan Perubahan</button>
                        </form>
                    </section>

                    <section class="tab-panel" data-profile-panel="booking">
                        <div class="panel-header">
                            <h2>Riwayat Booking</h2>
                            <p>Ringkasan pemesanan kos atau kontrakan Anda</p>
                        </div>

                        @php
                            $latestBooking = $bookings->sortByDesc('updated_at')->first();
                            $statusHighlight = $latestBooking && $latestBooking->status !== 'Pending';
                        @endphp

                        @if ($statusHighlight)
                            @php
                                $statusClass = \Illuminate\Support\Str::slug($latestBooking->status, '-');
                                $alertClass = $latestBooking->status === 'Diterima' ? 'success' : 'error';
                            @endphp
                            <div class="profile-alert {{ $alertClass }}">
                                <i
                                    class="bi {{ $latestBooking->status === 'Diterima' ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                                Booking #{{ $latestBooking->id_booking ?? '—' }}
                                {{ strtolower($latestBooking->status) }}.
                            </div>
                        @endif

                        @if ($bookings->isEmpty())
                            <p class="empty-state">Belum ada riwayat booking. Mulai booking kos atau kontrakan favorit
                                Anda.</p>
                        @else
                            <div class="booking-list">
                                @foreach ($bookings as $booking)
                                    @php
                                        $type = $booking->kosan ? 'Kosan' : 'Kontrakan';
                                        $name =
                                            $booking->kosan->nama_kosan ?? ($booking->kontrakan->nama_kontrakan ?? '-');
                                        $bookingId = $booking->id_booking ?? '—';
                                        $statusClass = \Illuminate\Support\Str::slug($booking->status, '-');
                                        $startDate = $booking->tanggal_mulai
                                            ? \Carbon\Carbon::parse($booking->tanggal_mulai)
                                            : null;
                                        $endDate = $booking->tanggal_selesai
                                            ? \Carbon\Carbon::parse($booking->tanggal_selesai)
                                            : null;
                                        $duration = $startDate && $endDate ? $startDate->diffInDays($endDate) : null;
                                    @endphp
                                    <article class="booking-item"
                                        data-aos="fade-up"data-aos-delay="{{ $loop->iteration * 100 }}"
                                        data-aos-anchor-placement="top-bottom">
                                        <div class="booking-item__top">
                                            <div>
                                                <span class="booking-type">{{ $type }}</span>
                                                <h3>{{ $name }}</h3>
                                            </div>
                                            <div class="booking-meta">
                                                <span class="booking-code">#{{ $bookingId }}</span>
                                                <span class="booking-status is-{{ $statusClass }}">
                                                    {{ $booking->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="booking-item__details">
                                            <div>
                                                <small>Tanggal</small>
                                                <p>
                                                    {{ $startDate ? $startDate->translatedFormat('d M Y') : '-' }}
                                                    -
                                                    {{ $endDate ? $endDate->translatedFormat('d M Y') : '-' }}
                                                </p>
                                            </div>
                                            <div>
                                                <small>Durasi</small>
                                                <p>{{ $duration !== null ? $duration . ' Hari' : '-' }}</p>
                                            </div>
                                            <div>
                                                <small>Total Biaya</small>
                                                <p>Rp {{ number_format($booking->jumlah_biaya, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                        <div class="booking-item__actions">
                                            <button type="button" class="btn btn-outline" data-booking-proof-trigger
                                                data-proof-id="{{ $bookingId }}"
                                                data-proof-listing="{{ $name }}"
                                                data-proof-type="{{ $type }}"
                                                data-proof-nama="{{ $booking->user->nama ?? $user->nama }}"
                                                data-proof-email="{{ $booking->user->email ?? $user->email }}"
                                                data-proof-telepon="{{ $booking->telepon }}"
                                                data-proof-tanggal-pengajuan="{{ \Carbon\Carbon::parse($booking->created_at)->translatedFormat('d F Y') }}"
                                                data-proof-tanggal-mulai="{{ $startDate ? $startDate->translatedFormat('d F Y') : '-' }}"
                                                data-proof-tanggal-selesai="{{ $endDate ? $endDate->translatedFormat('d F Y') : '-' }}"
                                                data-proof-biaya="{{ number_format($booking->jumlah_biaya, 0, ',', '.') }}"
                                                data-proof-price-unit=""
                                                data-proof-kontak="{{ $booking->kosan->kontak_kosan ?? ($booking->kontrakan->kontak_kontrakan ?? $booking->telepon) }}">
                                                Bukti Pengajuan
                                            </button>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif
                    </section>
                </div>
            </div>
        </main>

        @include('user.home.partials.footer')
    </div>

    <div class="booking-proof-overlay" data-booking-proof>
        <div class="booking-proof-modal">
            <button class="booking-proof-close" data-close-booking-proof aria-label="Tutup bukti pengajuan">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="booking-proof-header">
                <div class="booking-proof-icon">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <div>
                    <p class="booking-proof-subtitle">Bukti Pengajuan Booking</p>
                    <h3 class="booking-proof-title"><span data-proof-type></span> <span data-proof-listing></span></h3>
                </div>
            </div>

            <div class="booking-proof-meta">
                <div>
                    <p class="label">ID Booking</p>
                    <p class="value" data-proof-id>—</p>
                </div>
                <div class="text-end">
                    <p class="label">Tanggal Pengajuan</p>
                    <p class="value" data-proof-tanggal-pengajuan>—</p>
                </div>
            </div>

            <div class="booking-proof-card">
                <p class="card-title">Informasi Penyewa</p>
                <dl class="proof-detail">
                    <div class="proof-detail-row">
                        <dt>Nama Lengkap :</dt>
                        <dd data-proof-nama>—</dd>
                    </div>
                    <div class="proof-detail-row">
                        <dt>Email :</dt>
                        <dd data-proof-email>—</dd>
                    </div>
                    <div class="proof-detail-row">
                        <dt>Nomor Telepon :</dt>
                        <dd data-proof-telepon>—</dd>
                    </div>
                    <div class="proof-detail-row">
                        <dt>Tanggal Mulai Sewa :</dt>
                        <dd data-proof-tanggal-mulai>—</dd>
                    </div>
                    <div class="proof-detail-row">
                        <dt>Tanggal Selesai Sewa :</dt>
                        <dd data-proof-tanggal-selesai>—</dd>
                    </div>
                    <div class="proof-detail-row">
                        <dt>Total Biaya Sewa :</dt>
                        <dd data-proof-biaya>—</dd>
                    </div>
                </dl>
            </div>

            <div class="booking-proof-card is-note">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-exclamation-circle text-warning"></i>
                    <p class="card-title mb-0">Catatan Penting</p>
                </div>
                <p class="mb-2">Bukti ini bukan konfirmasi booking final.</p>
                <p class="mb-3">Simpan bukti ini untuk ditunjukkan kepada pemilik kos. Kirim langsung melalui
                    WhatsApp
                    menggunakan tombol di bawah.</p>
                <div class="wa-contact">
                    <div class="wa-contact__meta">
                        <div class="wa-contact__badge">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <div>
                            <p class="wa-contact__label">Kontak Pemilik</p>
                            <p class="wa-contact__number" data-proof-wa-number>—</p>
                        </div>
                    </div>
                    <a class="wa-contact__action d-none" data-proof-wa-link target="_blank" rel="noopener">
                        Kirim via WhatsApp
                        <i class="bi bi-arrow-up-right"></i>
                    </a>
                </div>
            </div>
            <div class="booking-proof-actions">
                <button type="button" class="btn btn-primary grow" data-print-booking-proof>
                    <i class="bi bi-printer me-2"></i> Cetak Bukti
                </button>
                <button type="button" class="btn btn-outline-secondary grow" data-close-booking-proof>Tutup</button>
            </div>
        </div>
    </div>

    @include('user.home.partials.login-modal')
</body>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 900,
        once: true,
    });
</script>

</html>
