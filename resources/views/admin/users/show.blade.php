@extends('layouts.admin')

@section('content')


<div class="card shadow-sm p-4 mx-auto" style="max-width: 800px; border-radius: 15px;">
    <div class="mb-4">
        <h5 class="fw-bold mb-4 fs-4 text-center">Data User</h5>
        <h6 class="fw-bold text-primary mb-3">Detail User</h6>
        <div class="d-flex align-items-center">
            <div class="rounded-2 bg-primary text-white d-flex align-items-center justify-content-center"
                style="width:55px;height:55px;">
                👤
            </div>
            <div class="ms-3">
                <h5 class="fw-bold mb-0">{{ $user->nama }}</h5>
                <small class="text-muted">Pengguna</small>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <h6 class="fw-bold text-primary mb-3">Email</h6>
        <div class="d-flex align-items-center">
            <div class="rounded-2 bg-primary text-white d-flex align-items-center justify-content-center"
                style="width:55px;height:55px;">
                📧
            </div>
            <div class="ms-3">
                <h5 class="fw-bold mb-0">{{ $user->email }}</h5>
                <small class="text-muted">Email</small>
            </div>
        </div>
    </div>
    
        <a href="{{route('admin.users.index')}}" class="btn btn-outline-secondary px-4 mt-3 bi bi-arrow-left-circle"> Kembali</a>
</div>
@endsection
