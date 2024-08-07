@extends('admin.layout.master')
@section('title', 'Users Registrasi | SILAPOR')

@section('content')
    <div class="row mb-3">
        <div class="col-lg">
            <h3>Edit Users Registrasi</h3>
            <p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="border: none; margin-left: -15px;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('data-user.index') }}">Data Users Registrasi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Users Registrasi</li>
                </ol>
            </nav>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-user.update', $users->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-user.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Simpan Data
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $users->name ?? '') }}" placeholder="Masukan Nama Lengkap">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $users->email ?? '') }}" placeholder="Masukan Email Address"
                                readonly>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Status Autentikasi</label>
                            <select name="level_id" class="form-control @error('level_id') is-invalid @enderror"
                                style="width: 100%" id="selectedStatus">
                                <option value="" selected>Pilih Status Autentikasi</option>
                                @foreach ($levels as $data)
                                    <option value="{{ $data->id_level }}"
                                        {{ $users->level_id == $data->id_level ? 'selected' : '' }}>
                                        {{ $data->namalevel ?? '-' }}</option>
                                @endforeach
                            </select>
                            @error('level_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Telepon</label>
                            <input type="number" name="telp" class="form-control @error('telp') is-invalid @enderror"
                                value="{{ old('telp', $users->telp ?? '') }}" placeholder="Masukan nomor telepon">
                            @error('telp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('custom-script')
    <script>
        $(document).ready(function() {
            $('#selectedStatus').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
