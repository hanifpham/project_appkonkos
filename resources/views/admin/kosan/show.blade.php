@extends('layouts.admin')

@section('content')
<div class="container py-4">

    {{-- Card Utama --}}
    <div class="card card-animate shadow-sm p-4 mx-auto" style="max-width: 800px; border-radius: 15px;">

        {{-- Judul Kosan --}}
        <h4 class="fw-bold  mb-4 text-center text-primary">{{ $data->nama_kosan }}</h4>

        {{-- Gambar Utama --}}
        @php
            $storage = \Illuminate\Support\Facades\Storage::disk('public');
            $mainImage = $data->gambar_kosan && $storage->exists($data->gambar_kosan)
                ? asset('storage/' . $data->gambar_kosan)
                : asset('image/hero.png');
        @endphp
        <div class="text-center mb-4">
            <img src="{{ $mainImage }}" alt="Gambar Kosan" class="img-fluid rounded shadow-sm"
                style="max-height: 300px; object-fit: cover; width: 100%;">
        </div>

        {{-- Harga --}}
        <div class="text-center mb-4 p-3 rounded" style="background: #f0f8ff;">
            <h4 class="text-success fw-bolder mb-0">
                Rp {{ number_format($data->harga_bulan, 0, ',', '.') }}<small class="text-muted">/ bulan</small>
            </h4>
        </div>

        {{-- Detail Gambar Kosan --}}
        <div class="mb-4">
            <h6 class="fw-bold  mb-3">Detail Gambar Kosan</h6>
            @php
                $detailImages = collect(json_decode($data->detail_kosan, true) ?? [])
                    ->filter()
                    ->filter(fn($img) => $storage->exists($img))
                    ->map(fn($img) => asset('storage/' . $img))
                    ->values();
            @endphp
            <div class="d-flex flex-wrap">
                @forelse ($detailImages as $img)
                    <img src="{{ $img }}" class="rounded shadow-sm me-3 mb-3"
                        style="width:160px; height:120px; object-fit:cover;" alt="Detail kosan">
                @empty
                    <p class="text-muted small mb-0">Belum ada gambar detail.</p>
                @endforelse
            </div>
        </div>

        {{-- Informasi Cepat --}}
        <div class="mb-4 p-3 bg-light rounded shadow-sm">
            <h6 class="fw-bold  mb-2">Informasi Cepat</h6>
            <ul class="list-unstyled mb-0 small">
                <li><strong>Status:</strong> 
                    <span class="badge 
                        {{ $data->status == 'tersedia' ? 'bg-success' : ($data->status == 'tidak tersedia' ? 'bg-secondary' : 'bg-danger') }}">
                        {{ ucfirst($data->status) }}
                    </span>
                </li>
                <li><strong>Alamat:</strong> {{ $data->alamat }}</li>
                <li><strong>Kontak:</strong> {{ $data->kontak_kosan ?? '-' }}</li>
                <li><strong>Kamar Tersedia:</strong> {{ $data->kamar_yang_tersedia ?? '-' }}</li>
            </ul>
        </div>

        {{-- Fasilitas & Aturan --}}
        <div class="mb-4">
            <h6 class="fw-bold ">Fasilitas Kosan (Dalam Kamar)</h6>
            <p style="white-space: pre-wrap;">{{ $data->fasilitas_kosan }}</p>
            <hr>
            <h6 class="fw-bold ">Fasilitas Umum</h6>
            <p style="white-space: pre-wrap;">{{ $data->fasilitas_umum }}</p>
            <hr>
            <h6 class="fw-bold ">Peraturan Kosan</h6>
            <p style="white-space: pre-wrap;">{{ $data->peraturan_kosan }}</p>
        </div>

        {{-- Maps --}}
        <div class="mb-4">
            <h6 class="fw-bold  mb-3">Peta Lokasi</h6>
            @if ($data->maps)
                <div class="map-container mx-auto " style="width:80%; height:350px; overflow:hidden; border-radius:10px; border:1px solid #ddd;">
                    {!! $data->maps !!}
                </div>
            @endif
        </div>

        <a href="{{route('admin.kosan.index')}}" class="btn btn-outline-secondary px-7 mt-3 bi bi-arrow-left-circle"> Kembali</a>
    </div> {{-- End Card --}} 
</div>
@endsection
