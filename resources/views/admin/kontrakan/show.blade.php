@extends('layouts.admin')

@section('content')
<div class="container py-4">

    {{-- Card Utama --}}
    <div class="card card-animate shadow-sm p-4 mx-auto" style="max-width: 800px; border-radius: 15px;">

        {{-- Judul kontrakan --}}
        <h4 class="fw-bold text-primary mb-4 text-center">{{ $data->nama_kontrakan }}</h4>

        {{-- Gambar Utama --}}
        <div class="text-center mb-4">
            <img src="{{ asset('storage/' . $data->gambar_kontrakan) }}" alt="Gambar kontrakan" class="img-fluid rounded shadow-sm"
                 style="max-height: 300px; object-fit: cover; width: 100%;">
        </div>

        {{-- Harga --}}
        <div class="text-center mb-4 p-3 rounded" style="background: #f0f8ff;">
            <h4 class="text-success fw-bolder mb-0">
                Rp {{ number_format($data->harga_tahun, 0, ',', '.') }}<small class="text-muted">/ Tahun</small>
            </h4>
        </div>

        {{-- Detail Gambar kontrakan --}}
        <div class="mb-4">
            <h6 class="fw-bold mb-3">Detail Gambar kontrakan</h6>
            @php $detailImages = json_decode($data->detail_kontrakan, true) ?? []; @endphp
            <div class="d-flex flex-wrap">
                @foreach ($detailImages as $img)
                    <img src="{{ asset('storage/' . $img) }}" class="rounded shadow-sm me-3 mb-3"
                         style="width:160px; height:120px; object-fit:cover;">
                @endforeach
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
                <li><strong>Luas Kontrakan:</strong>{{ $data->luas_kontrakan }}</></li>
                <li><strong>Kontak:</strong> {{ $data->kontak_kontrakan ?? '-' }}</li>
                <li><strong>Jumlah Kamar:</strong>{{ $data->jumlah_kamar }}</></li>
            </ul>
        </div>

        {{-- Fasilitas --}}
        <div class="mb-4">
            <h6 class="fw-bold">Fasilitas kontrakan (Dalam Kamar)</h6>
            <p style="white-space: pre-wrap;">{{ $data->fasilitas_kontrakan }}</p>
            <hr>
            <h6 class="fw-bold">Fasilitas Umum</h6>
            <p style="white-space: pre-wrap;">{{ $data->fasilitas_umum }}</p>
            <hr>
            <h6 class="fw-bold">Peraturan Kontrakan</h6>
            <p style="white-space: pre-wrap;">{{ $data->peraturan_kontrakan }}</p>
        </div>

        {{-- Maps --}}
        <div class="mb-4">
            <h6 class="fw-bold mb-3">Peta Lokasi</h6>
            @if ($data->maps)
                <div class="map-container mx-auto" style="width:80%; height:350px; overflow:hidden; border-radius:10px; border:1px solid #ddd;">
                    {!! $data->maps !!}
                </div>
            @endif
        </div>

        
        <a href="{{route('admin.kontrakan.index')}}" class="btn btn-outline-secondary px-4 mt-3bi bi-arrow-left-circle"> kembali</a>
    </div> {{-- End Card --}}
</div>
@endsection
