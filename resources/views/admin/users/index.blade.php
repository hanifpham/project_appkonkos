@extends('layouts.admin')

@section('content')
    <h5 class="fw-bold mb-4 fs-4" data-aos="fade-right" data-aos-duration="600">Data User</h5>

    <div data-aos="fade-right" data-aos-delay="100" data-aos-duration="600">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3 shadow-sm">
            <i class="bi bi-plus-lg"></i> Tambah data
        </a>
    </div>

    <div class="card shadow border-0" data-aos="fade-up" data-aos-delay="200">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mb-0 align-middle">
                <thead class="table-primary text-center align-middle">
                    <tr>
                        <th style="width: 70px;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width: 300px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($data as $b)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $b->nama }}</td>
                            <td class="text-center">{{ $b->email }}</td>
                            <td>
                                <span class="badge {{ $b->role == 'admin' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($b->role) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-group d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.users.show', $b->id) }}" class="btn btn-info btn-sm btn-action text-white">
                                        <i class="bi bi-eye-fill"></i> Info
                                    </a>

                                    {{-- <a href="{{ route('admin.users.edit', $b->id) }}" class="btn btn-warning btn-sm btn-action text-dark">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a> --}}

                                    <form action="{{ route('admin.users.destroy', $b->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-action">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection