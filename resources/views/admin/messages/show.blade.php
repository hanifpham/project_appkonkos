@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold fs-4 mb-1">Detail Pesan</h5>
            <p class="text-muted mb-0">Lihat isi pesan lengkap dari pengguna.</p>
        </div>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow border-0 p-4">
        <div class="mb-3">
            <small class="text-muted d-block">Nama Pengirim</small>
            <h6 class="mb-0">{{ $message->nama }}</h6>
        </div>
        <div class="mb-3">
            <small class="text-muted d-block">Email</small>
            <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
        </div>
        <div class="mb-3">
            <small class="text-muted d-block">Dikirim Pada</small>
            <span>{{ $message->created_at->format('d M Y, H:i') }}</span>
        </div>
        <div>
            <small class="text-muted d-block">Isi Pesan</small>
            <p class="mb-0">{{ $message->pesan }}</p>
        </div>

        <div class="d-flex gap-2 mt-4">
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST"
                onsubmit="return confirm('Hapus pesan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
@endsection
