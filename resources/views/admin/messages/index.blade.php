@extends('layouts.admin')

@section('content')
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center mb-4 gap-2" 
         data-aos="fade-right" 
         data-aos-duration="600">
        <div>
            <h5 class="fw-bold fs-4 mb-1">Pesan Pengguna</h5>
            <p class="text-muted mb-0">Masukan dan keluhan yang dikirim dari halaman utama.</p>
        </div>
    </div>

    <div class="card shadow card-animate p-0 border-0" 
         data-aos="fade-up" 
         data-aos-delay="200">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mb-0 align-middle">
                <thead class="table-primary text-center align-middle">
                    <tr>
                        <th style="width: 70px;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Pesan</th>
                        <th style="width: 170px;">Dikirim</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $index => $message)
                        <tr>
                            <td class="text-center">{{ $messages->firstItem() + $index }}</td>
                            <td>{{ $message->nama }}</td>
                            <td>{{ $message->email }}</td>
                            <td class="text-break">{{ \Illuminate\Support\Str::limit($message->pesan, 50) }}</td>
                            <td>{{ $message->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.messages.show', $message) }}"
                                        class="btn btn-info btn-action text-white">
                                        <i class="bi bi-eye"></i> Info
                                    </a>
                                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST"
                                        onsubmit="return confirm('Hapus pesan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-action">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class=" d-flex flex-column align-items-center">
                                    <i class="bi bi-chat-left-dots fs-1 text-muted"></i>
                                    <p class="text-muted mt-2 fw-semibold">Kotak masuk masih kosong.</p>
                                    <small class="text-muted">Belum ada pesan atau feedback dari pengguna.</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection