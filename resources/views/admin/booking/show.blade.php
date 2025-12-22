@extends('layouts.admin')

@section('content')

<h4 class="fw-bold mb-4">Detail Booking</h4>

<div class="card shadow card-animate">
    <div class="card-body">

        <h5 class="fw-bold mb-3">Informasi Booking</h5>

        <table class="table table-bordered">
            <tr>
                <th>Kode Booking</th>
                <td>{{ $booking->id_booking }}</td>
            </tr>

            <tr>
                <th>User</th>
                <td>{{ $booking->user->nama }}</td>
            </tr>

            <tr>
                <th>Telepon</th>
                <td>{{ $booking->telepon }}</td>
            </tr>

            <tr>
                <th>Kosan / Kontrakan</th>
                <td>
                    @if ($booking->kosan)
                        Kosan: <strong>{{ $booking->kosan->nama_kosan }}</strong>
                    @elseif ($booking->kontrakan)
                        Kontrakan: <strong>{{ $booking->kontrakan->nama_kontrakan }}</strong>
                    @else
                        -
                    @endif
                </td>
            </tr>

            <tr>
                <th>Tanggal Mulai</th>
                <td>{{ $booking->tanggal_mulai }}</td>
            </tr>

            <tr>
                <th>Tanggal Selesai</th>
                <td>{{ $booking->tanggal_selesai }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <span class="badge 
                        @if($booking->status == 'Pending') bg-warning 
                        @elseif($booking->status == 'Diterima') bg-success 
                        @else bg-danger @endif">
                        {{ $booking->status }}
                    </span>
                </td>
            </tr>

            <tr>
                <th>Total Biaya</th>
                <td>Rp {{ number_format($booking->jumlah_biaya, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary">
                Kembali
            </a>

            <form action="{{ route('admin.booking.updateStatus', $booking->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="Diterima">
                <button class="btn btn-success" {{ $booking->status === 'Diterima' ? 'disabled' : '' }}>
                    Terima
                </button>
            </form>

            <form action="{{ route('admin.booking.updateStatus', $booking->id) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="Ditolak">
                <button class="btn btn-warning" {{ $booking->status === 'Ditolak' ? 'disabled' : '' }}>
                    Tolak
                </button>
            </form>
        </div>

    </div>
</div>

@endsection
