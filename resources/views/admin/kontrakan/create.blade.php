@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="card card-animate shadow-sm p-4 mx-auto" style="max-width: 900px; border-radius: 15px;">
            <form id="formkontrakan" action="{{ route('admin.kontrakan.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <h4 class="mb-4 fw-bold text-primary text-center"><i><i class="bi bi-plus-lg"></i></i> Tambah Data Kontrakan
                </h4>
                {{-- === LANGKAH 1 (Informasi Utama & Media) === --}}
                <div id="step1">
                    <h5 class=" mb-3">Informasi Dasar</h5>

                    {{-- Nama kontrakan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Nama kontrakan</label>
                        <input type="text" name="nama_kontrakan" class="form-control" placeholder="Masukkan nama kontrakan"
                            value="{{ old('nama_kontrakan') }}" required>
                        @error('nama_kontrakan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Alamat kontrakan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Alamat kontrakan</label>
                        <input type="text" name="alamat" class="form-control" placeholder="Masukkan alamat kontrakan"
                            value="{{ old('alamat') }}" required>
                        @error('alamat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- luas kontrakan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Luas Kontrakan</label>
                        <input type="text" name="luas_kontrakan" class="form-control" placeholder="Masukkan luas kontrakan"
                            value="{{ old('luas_kontrakan') }}" required>
                        @error('luas_kontrakan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Kontak kontrakan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Kontak kontrakan</label>
                        <input type="text" name="kontak_kontrakan" class="form-control"
                            placeholder="Masukkan kontak kontrakan" value="{{ old('kontak_kontrakan') }}" required>
                        @error('kontak_kontrakan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Harga kontrakan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Harga kontrakan (per Tahun)</label>
                        <input type="number" name="harga_tahun" class="form-control" placeholder="Masukkan harga kontrakan"
                            value="{{ old('harga_tahun') }}" required>
                        @error('harga_tahun')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <h5 class=" mt-4 mb-3">Media & Lokasi</h5>

                    {{-- Gambar kontrakan (Utama) --}}
                    <div class="row text-center">
                        <div class="col-md-6 mb-3 mx-auto">
                            <label class="form-label fw-semibold ">Gambar kontrakan (Utama)</label>

                            <div class="upload-box"
                                style="height: 150px; width:100%; border: 1px dashed #ccc; cursor: pointer; display: flex; flex-direction: column; justify-content: center; align-items: center; border-radius: 10px;">
                                <i class="bi bi-image fs-1 text-muted"></i>
                                <small class="text-muted">Klik untuk upload</small>

                                <input type="file" name="gambar_kontrakan" class="file-input" accept="image/*"
                                    style="opacity: 0; position: absolute; width: 100%; height: 100%; cursor: pointer;"
                                    required>
                            </div>
                            @error('gambar_kontrakan')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Detail Gambar kontrakan (Multiple) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">
                            Detail Gambar Kontrakan (Opsional, bisa lebih dari satu)
                        </label>
                        <input type="file" name="detail_kontrakan[]" class="form-control" accept="image/*" multiple>
                        @error('detail_kontrakan.*')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Link Google Maps --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Link Google Maps</label>
                        <input type="text" name="maps" id="mapsInput" class="form-control"
                            placeholder="Tempelkan seluruh kode html iframe dari opsi sematkan Peta"
                            value="{{ old('maps') }}">
                        @error('maps')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Tombol Next --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ Route('admin.kontrakan.index') }}"
                            class="btn btn-outline-secondary px-4 bi bi-arrow-left-circle"> Kembali</a>
                        <button type="button" class="btn btn-primary px-4" id="nextBtn">Selanjutnya</button>
                    </div>
                </div>

                {{-- === LANGKAH 2 (Fasilitas & Status) === --}}
                <div id="step2" style="display: none;">
                    <h5 class=" mb-3">Fasilitas & Peraturan</h5>

                    {{-- Fasilitas kontrakan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Fasilitas kontrakan (di dalam kamar)</label>
                        <textarea name="fasilitas_kontrakan" class="form-control" rows="3"
                            placeholder="Masukkan fasilitas kontrakan: AC, TV, dll">{{ old('fasilitas_kontrakan') }}</textarea>
                        @error('fasilitas_kontrakan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Fasilitas Umum --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Fasilitas Umum</label>
                        <textarea name="fasilitas_umum" class="form-control" rows="3"
                            placeholder="Masukkan fasilitas umum: parkiran dan dapur">{{ old('fasilitas_umum') }}</textarea>
                        @error('fasilitas_umum')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Peraturan Kontrakan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Peraturan Kontrakan</label>
                        <textarea name="peraturan_kontrakan" class="form-control" rows="3"
                            placeholder="Tuliskan peraturan kontrakan: jam malam, larangan hewan, dll">{{ old('peraturan_kontrakan') }}</textarea>
                        @error('peraturan_kontrakan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- jumlah kamar --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Jumlah kamar</label>
                        <input type="text" name="jumlah_kamar" class="form-control"
                            placeholder="Masukkan jumlah kamar contoh: 4" value="{{ old('jumlah_kamar') }}">
                        @error('jumlah_kamar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Status kontrakan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold ">Status kontrakan</label>
                        <select name="status" class="form-select">
                            <option value="tersedia" {{ old('status', 'tersedia') == 'tersedia' ? 'selected' : '' }}>
                                Tersedia</option>
                            <option value="tidak tersedia" {{ old('status') == 'tidak tersedia' ? 'selected' : '' }}>Tidak
                                Tersedia</option>
                            <option value="batal" {{ old('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>

                    {{-- Tombol Navigasi --}}
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary px-4 bi bi-arrow-left-circle" id="backBtn">
                            Kembali</button>
                        <button type="submit" class="btn btn-primary btn  px-5 bi bi-save"> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Script navigasi --}}
    <script>
        document.getElementById('nextBtn').addEventListener('click', function () {
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
        });

        document.getElementById('backBtn').addEventListener('click', function () {
            document.getElementById('step1').style.display = 'block';
            document.getElementById('step2').style.display = 'none';
        });

        // Preview Gambar
        document.querySelectorAll('.file-input').forEach(input => {
            input.addEventListener('change', function (e) {
                const file = e.target.files[0];
                const uploadBox = e.target.closest('.upload-box');
                const icon = uploadBox.querySelector('i');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        uploadBox.querySelector('img')?.remove();
                        const imgPreview = document.createElement('img');
                        imgPreview.src = event.target.result;
                        imgPreview.style.maxWidth = "100%";
                        imgPreview.style.maxHeight = "120px";
                        imgPreview.style.borderRadius = "10px";
                        icon.style.display = 'none';
                        uploadBox.querySelector('small').style.display = 'none';
                        uploadBox.appendChild(imgPreview);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection