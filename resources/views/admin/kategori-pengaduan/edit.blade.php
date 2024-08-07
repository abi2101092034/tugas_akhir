@extends('admin.layout.master')
@section('title', 'Kategori Pengaduan | SILAPOR')

@section('content')
    <div class="row mb-3">
        <div class="col-lg">
            <h3>Edit Kategori Pengaduan</h3>
            <p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="border: none; margin-left: -15px;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('data-kategoripengaduan.index') }}">Data Kategori
                            Pengaduan</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Kategori Pengaduan</li>
                </ol>
            </nav>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-kategoripengaduan.update', $kategoris->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-kategoripengaduan.index') }}" class="btn btn-primary">
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
                            <label>Nama Kategori Pengaduan</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $kategoris->nama ?? '') }}" placeholder="Masukan Nama Kategori">
                            @error('nama')
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
