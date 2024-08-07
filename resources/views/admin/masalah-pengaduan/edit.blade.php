@extends('admin.layout.master')
@section('title', 'Masalah Pengaduan | SILAPOR')

@section('content')
    <div class="row mb-3">
        <div class="col-lg">
            <h3>Edit Masalah Pengaduan</h3>
            <p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="border: none; margin-left: -15px;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('data-masalahpengaduan.index') }}">Data Kategori
                            Pengaduan</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Masalah Pengaduan</li>
                </ol>
            </nav>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-masalahpengaduan.update', $masalahs->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-masalahpengaduan.index') }}" class="btn btn-primary">
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
                            <label>Kode Masalah Pengaduan</label>
                            <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                                value="{{ old('kode', $masalahs->kode ?? '') }}" placeholder="Masukan Kode Kategori">
                            @error('kode')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Kategori</label>
                            <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror"
                                style="width: 100%" id="selectedKategori">
                                <option value="" selected>Pilih Kategori Pengaduan</option>
                                @foreach ($kategoris as $data)
                                    <option value="{{ $data->id }}"
                                        {{ $masalahs->kategori_id == $data->id ? 'selected' : '' }}>
                                        {{ $data->nama ?? '-' }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Nama Masalah Pengaduan</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $masalahs->nama ?? '') }}" placeholder="Masukan Nama Kategori">
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
@push('custom-script')
    <script>
        $(document).ready(function() {
            $('#selectedKategori').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
