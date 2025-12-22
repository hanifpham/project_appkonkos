@extends('layouts.admin')
@section('content')
    <h5 class="fw-bold mb-4 fs-4" data-aos="fade-right" data-aos-duration="800">Data kosan</h5>

    <div class="card-header d-flex flex-wrap justify-content-center justify-content-xl-between mb-3" data-aos="fade-right"
        data-aos-delay="100" data-aos-duration="800">
        <a href="{{ route('admin.kosan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah data
        </a>
        <a href="{{ route('admin.kosan.pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf-fill"></i> Pdf
        </a>
    </div>

    <div data-aos="fade-up" data-aos-delay="200" data-aos-duration="400">
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-primary text-center align-middle" style="background-color:#0d47a1; color:white;">
                    <tr>
                        <th>No</th>
                        <th>Nama kosan</th>
                        <th>Alamat</th>
                        <th>Harga/Bulan</th>
                        <th>Gambar</th>
                        <th>Fasilitas kosan</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $k)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $k->nama_kosan }}</td>
                            <td>{{ $k->alamat }}</td>
                            <td>Rp {{ number_format($k->harga_bulan, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <img src="{{ asset('storage/' . $k->gambar_kosan) }}" alt="Gambar kosan" width="60"
                                    class="rounded shadow-sm">
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($k->fasilitas_kosan, 30) }}</td>
                            <td>{{ $k->kontak_kosan }}</td>
                            <td class="text-center">
                                <span class="badge {{ $k->status == 'tersedia' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($k->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.kosan.show', $k->id) }}" class="btn btn-info btn-sm text-white">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('admin.kosan.edit', $k->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.kosan.destroy', $k->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-folder2-open fs-1 text-muted"></i>
                                    <p class="text-muted mt-2 fw-semibold">Belum ada data kosan yang tersedia.</p>
                                    <small class="text-muted">Silahkan klik tombol "Tambah data" untuk mengisi kosan
                                        baru.</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection