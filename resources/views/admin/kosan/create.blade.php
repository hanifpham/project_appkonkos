@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm card-animate p-4 mx-auto" style="max-width: 900px; border-radius: 15px;">
            <form id="formkosan" action="{{ route('admin.kosan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h4 class="mb-4 fw-bold text-center text-primary"><i><i class="bi bi-plus-lg"></i></i> Tambah Data Kosan</h4>
                {{-- === LANGKAH 1 (Informasi Utama & Media) === --}}
                <div id="step1">
                    <h5 class=" mb-3">Informasi Dasar</h5>
                    
                    {{-- Nama Kosan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Nama Kosan</label>
                        <input type="text" name="nama_kosan" class="form-control"
                            value="{{ old('nama_kosan') }}" placeholder="Masukkan nama kosan">
                        @error('nama_kosan')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Alamat Kosan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Alamat Kosan</label>
                        <input type="text" name="alamat" class="form-control"
                            value="{{ old('alamat') }}" placeholder="Masukkan alamat kosan">
                        @error('alamat')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Kontak --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Kontak Kosan</label>
                        <input type="text" name="kontak_kosan" class="form-control"
                            value="{{ old('kontak_kosan') }}" placeholder="Masukkan kontak kosan">
                        @error('kontak_kosan')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Harga (per bulan)</label>
                        <input type="number" name="harga_bulan" class="form-control"
                            value="{{ old('harga_bulan') }}" placeholder="Masukkan harga kosan">
                        @error('harga_bulan')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <h5 class=" mt-4 mb-3">Media & Lokasi</h5>

                    {{-- Gambar utama --}}
                    <div class="row text-center">
                        <div class="col-md-6 mb-3 mx-auto">
                            <label class="form-label fw-semibold ">Gambar Kosan (Utama)</label>
                            <div class="upload-box" 
                                 style="height: 150px; width:100%; border: 1px dashed #ccc;
                                        cursor: pointer; display: flex; flex-direction: column;
                                        justify-content: center; align-items: center; border-radius: 10px;">
                                <i class="bi bi-image fs-1 text-muted"></i>
                                <small class="text-muted">Klik untuk upload</small>
                                <input type="file" name="gambar_kosan" class="file-input"
                                    accept="image/*"
                                    style="opacity: 0; position: absolute; width: 100%; height: 100%; cursor: pointer;">
                            </div>
                            @error('gambar_kosan')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Detail gambar --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Detail Gambar Kosan</label>
                        <input type="file" name="detail_kosan[]" class="form-control" accept="image/*" multiple>
                        @error('detail_kosan.*')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Maps --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Link Google Maps</label>
                        <input type="text" name="maps" class="form-control"
                            value="{{ old('maps') }}" placeholder="Masukkan link maps">
                        @error('maps')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- NEXT --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{route('admin.kosan.index')}}" class="btn btn-outline-secondary px-4 bi bi-arrow-left-circle"> Kembali</a></a>
                        <button type="button" class="btn btn-primary px-4" id="nextBtn">Selanjutnya</button>
                    </div>
                </div>

                {{-- === LANGKAH 2 === --}}
                <div id="step2" style="display: none;">
                    <h5 class=" mb-3">Fasilitas & Peraturan</h5>

                    {{-- Fasilitas --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Fasilitas Kosan</label>
                        <textarea name="fasilitas_kosan" class="form-control" rows="3" value="{{ old('fasilitas_kosan') }}" placeholder="Masukkan fasilitas kosan"></textarea>
                        @error('fasilitas_kosan')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Fasilitas Umum --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Fasilitas Umum</label>
                        <textarea name="fasilitas_umum" class="form-control" rows="3" value= "{{ old('fasilitas_umum') }}" placeholder="Masukkan fasilitas umum"></textarea>
                        @error('fasilitas_umum')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Peraturan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Peraturan Kosan</label>
                        <textarea name="peraturan_kosan" class="form-control" rows="3" value= "{{ old('peraturan_kosan') }}" placeholder="Masukkan peraturan kosan"></textarea>
                        @error('peraturan_kosan')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <h5 class=" mt-4 mb-3">Ketersediaan</h5>

                    {{-- Kamar tersedia --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Kamar tersedia</label>
                        <input type="text" name="kamar_yang_tersedia" class="form-control"
                               value="{{ old('kamar_yang_tersedia') }}" placeholder="contoh: A1, A2, dll">
                        @error('kamar_yang_tersedia')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Status Kosan</label>
                        <select name="status" class="form-select">
                            <option value="tersedia">Tersedia</option>
                            <option value="tidak tersedia">Tidak Tersedia</option>
                            <option value="batal">Batal</option>
                        </select>
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary px-4 bi bi-arrow-left-circle" id="backBtn"> Kembali</button>
                        <button type="submit" class="btn btn-primary px-5 bi bi-save"> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Step --}}
    <script>
        document.getElementById('nextBtn').addEventListener('click', function() {
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
        });

        document.getElementById('backBtn').addEventListener('click', function() {
            document.getElementById('step1').style.display = 'block';
            document.getElementById('step2').style.display = 'none';
        });

        // preview
        document.querySelectorAll('.file-input').forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const uploadBox = e.target.closest('.upload-box');
                const icon = uploadBox.querySelector('i');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        uploadBox.querySelector('img')?.remove();
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.style.maxWidth = "100%";
                        img.style.maxHeight = "120px";
                        img.style.borderRadius = "10px";
                        icon.style.display = 'none';
                        uploadBox.querySelector('small').style.display = 'none';
                        uploadBox.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
