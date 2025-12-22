@extends('layouts.admin')

@section('content')
    <div class="container mt-4">

        <div class="card card-animate shadow-sm p-4 mx-auto" style="border-radius: 15px; max-width: 800px;">
            <div class="card-body p-4">

                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h4 class="fw-bold mb-4 text-center text-primary fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>Edit Data Booking
                    </h4>

                    {{-- User --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pelanggan</label>
                        <select name="user_id" class="form-select">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" 
                                    {{ $booking->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->nama }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kontrakan / Kosan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kosan/Kontrakan</label>
                        <select name="kontrakan_id" class="form-select">
                            @foreach ($kontrakans as $k)
                                <option value="{{ $k->id }}"
                                    {{ $booking->kontrakan_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kontrakan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control"
                               value="{{ old('tanggal_mulai', $booking->tanggal_mulai) }}" required>
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control"
                               value="{{ old('tanggal_selesai', $booking->tanggal_selesai) }}" required>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="paid" {{ $booking->status == 'paid' ? 'selected' : '' }}>
                                Paid
                            </option>
                            <option value="expired" {{ $booking->status == 'expired' ? 'selected' : '' }}>
                                Expired
                            </option>
                            <option value="canceled" {{ $booking->status == 'canceled' ? 'selected' : '' }}>
                                Canceled
                            </option>
                        </select>
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.booking.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
