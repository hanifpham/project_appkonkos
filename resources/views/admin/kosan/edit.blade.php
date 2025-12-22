@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="card card-animate shadow-sm p-4 mx-auto" style="max-width: 900px; border-radius: 15px;">
        <form action="{{ route('admin.kosan.update', $kosan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

             <h4 class="mb-4 fw-bold text-primary text-center"><i class="bi bi-pencil-square"></i> Edit Data Kosan</h4>
            {{-- Nama Kosan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Nama Kosan <span class="text-danger">*</span></label>
                <input type="text" name="nama_kosan" class="form-control"
                    value="{{ old('nama_kosan', $kosan->nama_kosan) }}">
                @error('nama_kosan')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Alamat <span class="text-danger">*</span></label>
                <input type="text" name="alamat" class="form-control"
                    value="{{ old('alamat', $kosan->alamat) }}">
                @error('alamat')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Kontak --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Kontak Kosan</label>
                <input type="text" name="kontak_kosan" class="form-control"
                    value="{{ old('kontak_kosan', $kosan->kontak_kosan) }}">
                @error('kontak_kosan')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Harga --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Harga per Bulan <span class="text-danger">*</span></label>
                <input type="number" name="harga_bulan" class="form-control"
                    value="{{ old('harga_bulan', $kosan->harga_bulan) }}">
                @error('harga_bulan')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Kamar --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Kamar yang tersedia</label>
                <input type="text" name="kamar_yang_tersedia" class="form-control"
                    value="{{ old('kamar_yang_tersedia', $kosan->kamar_yang_tersedia) }}">
                @error('kamar_yang_tersedia')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <hr class="my-4">

            {{-- Gambar utama --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Gambar Kosan Utama</label>
                @if ($kosan->gambar_kosan)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $kosan->gambar_kosan) }}" width="150"
                            class="rounded shadow-sm border">
                    </div>
                @endif
                <input type="file" name="gambar_kosan" class="form-control" accept="image/*">
                @error('gambar_kosan')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Detail gambar --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Detail Gambar Kosan</label>

                @php $detailImages = json_decode($kosan->detail_kosan, true) ?? []; @endphp

                <div class="d-flex flex-wrap mb-2 p-2 border rounded bg-light">
                    @forelse ($detailImages as $img)
                        <img src="{{ asset('storage/' . $img) }}" width="100" height="80"
                            class="rounded me-2 mb-2 shadow-sm" style="object-fit: cover;">
                    @empty
                        <small class="text-muted fst-italic">Belum ada gambar detail.</small>
                    @endforelse
                </div>

                <input type="file" name="detail_kosan[]" class="form-control" multiple accept="image/*">
                <small class="text-danger">Upload baru akan mengganti semua gambar lama.</small>

                @error('detail_kosan.*')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <hr class="my-4">

            {{-- Fasilitas --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Fasilitas Kosan</label>
                <textarea name="fasilitas_kosan" class="form-control" rows="3">{{ old('fasilitas_kosan', $kosan->fasilitas_kosan) }}</textarea>
                @error('fasilitas_kosan')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Fasilitas Umum --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Fasilitas Umum</label>
                <textarea name="fasilitas_umum" class="form-control" rows="3">{{ old('fasilitas_umum', $kosan->fasilitas_umum) }}</textarea>
                @error('fasilitas_umum')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Peraturan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Peraturan Kosan</label>
                <textarea name="peraturan_kosan" class="form-control" rows="3">{{ old('peraturan_kosan', $kosan->peraturan_kosan) }}</textarea>
                @error('peraturan_kosan')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <hr class="my-4">

            {{-- Maps --}}
            <div class="mb-3">
                <label class="form-label fw-semibold ">Link Google Maps (Iframe)</label>
                <textarea name="maps" class="form-control" rows="4">{{ old('maps', $kosan->maps) }}</textarea>

                @if ($kosan->maps)
                    <div class="mt-3" style="width:100%; height:250px; overflow:hidden; border-radius:10px;">
                        {!! str_replace('<iframe', '<iframe style="width:100%;height:100%;border:none;"', $kosan->maps) !!}
                    </div>
                @endif

                @error('maps')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label class="form-label fw-semibold ">Status Kosan</label>
                <select name="status" class="form-select">
                    <option value="tersedia" {{ old('status', $kosan->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="tidak tersedia" {{ old('status', $kosan->status) == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    <option value="batal" {{ old('status', $kosan->status) == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-between pt-3 border-top">
                <a href="{{ route('admin.kosan.index') }}" class="btn btn-outline-secondary px-4 bi bi-arrow-left-circle"> Kembali</a>
                <button type="submit" class="btn btn-primary px-5">Simpan Perubahan</button>
            </div>

        </form>
    </div>
</div>
@endsection
