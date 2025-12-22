@extends('layouts.admin')

@section('title', 'Dashboard Utama')

@section('content')

    <div class="container-fluid">

        <div data-aos="fade-right" data-aos-duration="600">
            <h3 class="fw-bold mb-1">Dashboard Utama</h3>
            <p class="text-muted">
                Selamat datang di Dashboard Admin APPKONKOS — Ringkasan dan statistik aplikasi
            </p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="stat-card stat-card--primary">
                    <div class="stat-card__icon">
                        <i class="bi bi-buildings"></i>
                    </div>
                    <div>
                        <p class="stat-card__label">Total Properti</p>
                        <p class="stat-card__value">{{ $totalProperti ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="stat-card stat-card--success">
                    <div class="stat-card__icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <p class="stat-card__label">Total Pengguna</p>
                        <p class="stat-card__value">{{ $totalUsers ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                <div class="stat-card stat-card--warning">
                    <div class="stat-card__icon">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <div>
                        <p class="stat-card__label">Booking Aktif</p>
                        <p class="stat-card__value">{{ $totalBooking ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h5 class="fw-bold mt-4 mb-3" data-aos="fade-up" data-aos-delay="400">Data Kosan</h5>
        <div class="card shadow p-0 border-0 mb-4" data-aos="fade-up" data-aos-delay="500">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nama Kosan</th>
                            <th>Alamat</th>
                            <th>Harga/bulan</th>
                            <th>Gambar</th>
                            <th>Fasilitas</th>
                            <th>Kontak</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataKosan as $k)
                            <tr>
                                <td>{{ $k->id }}</td>
                                <td>{{ $k->nama_kosan }}</td>
                                <td>{{ $k->alamat }}</td>
                                <td>Rp {{ number_format($k->harga_bulan, 0, ',', '.') }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $k->gambar_kosan) }}" width="60" class="rounded">
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($k->fasilitas_kosan, 60) }}</td>
                                <td>{{ $k->kontak_kosan }}</td>
                                <td>
                                    <span class="badge {{ $k->status == 'tersedia' ? 'bg-success' : ($k->status == 'tidak tersedia' ? 'bg-secondary' : 'bg-danger') }}">
                                        {{$k->status}}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data kosan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <h5 class="fw-bold mt-4 mb-3" data-aos="fade-up" data-aos-delay="600">Data Kontrakan</h5>
        <div class="card shadow p-0 border-0" data-aos="fade-up" data-aos-delay="700">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Nama Kontrakan</th>
                            <th>Alamat</th>
                            <th>Harga/tahun</th>
                            <th>Gambar</th>
                            <th>Fasilitas</th>
                            <th>Kontak</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataKontrakan as $k)
                            <tr>
                                <td>{{ $k->id }}</td>
                                <td>{{ $k->nama_kontrakan }}</td>
                                <td>{{ $k->alamat }}</td>
                                <td>Rp {{ number_format($k->harga_tahun, 0, ',', '.') }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $k->gambar_kontrakan) }}" width="60" class="rounded">
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($k->fasilitas_kontrakan, 60) }}</td>
                                <td>{{ $k->kontak_kontrakan }}</td>
                                <td>
                                    <span class="badge {{$k->status == 'tersedia' ? 'bg-success' : ($k->status == 'tidak tersedia' ? 'bg-secondary' : 'bg-danger') }}">
                                        {{ $k->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data kontrakan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection