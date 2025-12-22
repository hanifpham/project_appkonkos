@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card card-animate shadow-sm p-4 mx-auto " style="max-width: 900px; border-radius: 15px;">
        <h4 class="mb-4 fw-bold text-primary text-center"><i class="bi bi-pencil-square"></i> Edit Data kontrakan</h4>
        <form action="{{ route('admin.kontrakan.update', $kontrakan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nama kontrakan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Nama kontrakan <span class="text-danger">*</span></label>
                <input type="text" name="nama_kontrakan" class="form-control" value="{{ old('nama_kontrakan', $kontrakan->nama_kontrakan) }}" required>
                @error('nama_kontrakan')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Alamat <span class="text-danger">*</span></label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $kontrakan->alamat) }}" required>
                @error('alamat')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Luas kontrakan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Luas kontrakan <span class="text-danger">*</span></label>
                <input type="text" name="luas_kontrakan" class="form-control" value="{{ old('luas_kontrakan', $kontrakan->luas_kontrakan) }}" required>
                @error('luas_kontrakan')
                <small class="text-danger">{{ $message }}</small>
                @enderror   
            </div>

            {{-- Kontak kontrakan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Kontak kontrakan</label>
                <input type="text" name="kontak_kontrakan" class="form-control" value="{{ old('kontak_kontrakan', $kontrakan->kontak_kontrakan) }}">
                @error('kontak_kontrakan')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Harga per Bulan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Harga per Tahun <span class="text-danger">*</span></label>
                <input type="number" name="harga_tahun" class="form-control" value="{{ old('harga_tahun', $kontrakan->harga_tahun) }}" required>
                @error('harga_tahun')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <hr class="my-4">

            {{-- Gambar kontrakan Utama --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Gambar kontrakan Utama</label>
                @if ($kontrakan->gambar_kontrakan)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $kontrakan->gambar_kontrakan) }}" width="150" class="rounded shadow-sm border" alt="Gambar Utama">
                    </div>
                @endif
                <input type="file" name="gambar_kontrakan" class="form-control" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                @error('gambar_kontrakan')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Detail kontrakan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Detail kontrakan</label>
                @php $detailImages = json_decode($kontrakan->detail_kontrakan, true) ?? []; @endphp
                <div class="d-flex flex-wrap mb-2 p-2 border rounded bg-light">
                    @forelse ($detailImages as $img)
                        @if ($img)
                            <img src="{{ asset('storage/' . $img) }}" width="100" height="80" class="rounded me-2 mb-2 shadow-sm" style="object-fit: cover;">
                        @endif
                    @empty
                        <small class="text-muted fst-italic">Belum ada gambar detail.</small>
                    @endforelse
                </div>
                <input type="file" name="detail_kontrakan[]" class="form-control" accept="image/*" multiple>
                <small class="text-danger">Memilih file baru akan menggantikan semua gambar detail yang ada.</small>
                @error('detail_kontrakan*')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <hr class="my-4">

            {{-- Fasilitas kontrakan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Fasilitas kontrakan</label>
                <textarea name="fasilitas_kontrakan" class="form-control" rows="3">{{ old('fasilitas_kontrakan', $kontrakan->fasilitas_kontrakan) }}</textarea>
                @error('fasilitas_kontrakan')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Fasilitas Umum --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Fasilitas Umum</label>
                <textarea name="fasilitas_umum" class="form-control" rows="3">{{ old('fasilitas_umum', $kontrakan->fasilitas_umum) }}</textarea>
                @error('fasilitas_umum')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Peraturan Kontrakan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Peraturan Kontrakan</label>
                <textarea name="peraturan_kontrakan" class="form-control" rows="3">{{ old('peraturan_kontrakan', $kontrakan->peraturan_kontrakan) }}</textarea>
                @error('peraturan_kontrakan')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Jumlah kamar --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Jumlah kamar</label>
                <input type="text" name="jumlah_kamar" class="form-control" value="{{ old('jumlah_kamar', $kontrakan->jumlah_kamar) }}">
                @error('jumlah_kamar')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <hr class="my-4">

            {{-- Maps --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Link Google Maps (Iframe)</label>
                <textarea name="maps" class="form-control" rows="4" placeholder="Tempelkan kode iframe">{{ old('maps', $kontrakan->maps ?? '') }}</textarea>
                @if ($kontrakan->maps)
                    <div class="mt-3" style="width:100%; height:250px; overflow:hidden; border-radius:10px; border:1px solid #ddd;">
                        @php
                            $mapsHtml = str_replace('<iframe', '<iframe style="width:100%;height:100%;border:none;"', $kontrakan->maps);
                        @endphp
                        {!! $mapsHtml !!}
                    </div>
                @endif
                @error('maps')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <hr class="my-4">


            {{-- Status --}}
            <div class="mb-4">
                <label class="form-label fw-semibold ">Status kontrakan <span class="text-danger">*</span></label>
                <select name="status" class="form-select">
                    <option value="tersedia" {{ old('status', $kontrakan->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="tidak tersedia" {{ old('status', $kontrakan->status) == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    <option value="batal" {{ old('status', $kontrakan->status) == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-between pt-3 border-top">
                <a href="{{ route('admin.kontrakan.index') }}" class="btn btn-outline-secondary px-4 bi bi-arrow-left-circle"> Kembali</a>
                <button type="submit" class="btn btn-primary px-5">Simpan Perubahan</button>
            </div>

        </form>
    </div>
</div>
@endsection
