@extends('admin.layout.master')
@section('title', 'Status Autentikasi | SILAPOR')

@section('content')
    <div class="row mb-3">
        <div class="col-lg">
            <h3>Tambah Status Autentikasi</h3>
            <p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="border: none; margin-left: -15px;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('data-level.index') }}">Data Status Autentikasi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Status Autentikasi</li>
                </ol>
            </nav>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-level.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-level.index') }}" class="btn btn-primary">
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
                            <label>ID Status</label>
                            <input type="number" name="id_level"
                                class="form-control @error('id_level') is-invalid @enderror" value="{{ old('id_level') }}"
                                placeholder="Masukan ID Status">
                            @error('id_level')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Nama Status</label>
                            <input type="text" name="namalevel"
                                class="form-control @error('namalevel') is-invalid @enderror" value="{{ old('namalevel') }}"
                                placeholder="Masukan Nama Status">
                            @error('namalevel')
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
