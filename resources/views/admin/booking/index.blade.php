@extends('layouts.admin')

@section('content')
<h4 class="mb-4 fw-bold" data-aos="fade-right" data-aos-duration="600">Data Booking</h4>

<div class="card shadow border-0" data-aos="fade-up" data-aos-delay="200">
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped mb-0 align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Kode Booking</th>
                    <th>User</th>
                    <th>Properti</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Status</th>
                    <th>Biaya</th>
                    <th style="width: 220px;">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-center">
                @foreach ($bookings as $b)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $b->id_booking }}</td>
                    <td class="text-start">{{ $b->user->nama ?? 'Tidak Ada' }}</td>
                    <td class="text-start">
                        @if($b->kosan)
                             {{ $b->kosan->nama_kosan }}
                        @elseif($b->kontrakan)
                              {{ $b->kontrakan->nama_kontrakan }}
                        @else
                            -
                        @endif
                    </td>

                    <td>{{ \Carbon\Carbon::parse($b->tanggal_mulai)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($b->tanggal_selesai)->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge py-2 px-3 
                            @if($b->status == 'Pending') bg-warning text-dark
                            @elseif($b->status == 'Diterima') bg-success
                            @else bg-danger @endif">
                            {{ $b->status }}
                        </span>
                    </td>

                    <td>Rp {{ number_format($b->jumlah_biaya, 0, ',', '.') }}</td>

                    <td>
                        <div class="action-group d-flex justify-content-center gap-1">
                            <a href="{{ route('admin.booking.show', $b->id) }}" class="btn btn-info btn-sm btn-action text-white" title="Detail">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            <form action="{{ route('admin.booking.updateStatus', $b->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Diterima">
                                <button class="btn btn-success btn-sm btn-action" {{ $b->status === 'Diterima' ? 'disabled' : '' }} title="Terima">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>

                            <form action="{{ route('admin.booking.updateStatus', $b->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="Ditolak">
                                <button class="btn btn-warning btn-sm btn-action text-dark" {{ $b->status === 'Ditolak' ? 'disabled' : '' }} title="Tolak">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>

                            <form action="{{ route('admin.booking.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Hapus data booking?')">
                                @csrf 
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm btn-action" title="Hapus">
                                    <i class="bi bi-trash-fill"></i>
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