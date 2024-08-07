@extends('admin.layout.master')
@section('title', 'Tanggapan | SILAPOR')

@section('content')

    <div class="row mb-3">
        <div class="col-lg">
            <h3>Tambah Data Tanggapan</h3>
            <p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="border: none; margin-left: -15px;">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Data Tanggapan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Data Tanggapan</li>
                </ol>
            </nav>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-tanggapan.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-tanggapan.index', $pengaduans->id) }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Simpan Data
                        </button>
                    </div>
                    <div class="card-body">
                        {{-- ID Pengaduan --}}
                        <input type="text" name="pengaduan_id" class="form-control" value="{{ $pengaduans->id }}" hidden>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tanggal Tanggapan</label>
                                    <input type="date" name="tgl_tanggapan"
                                        class="form-control @error('tgl_tanggapan') is-invalid @enderror"
                                        value="{{ old('tgl_tanggapan', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                    @error('tgl_tanggapan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Keterangan</label>
                                    <textarea name="isi_tanggapan" class="form-control @error('isi_tanggapan') is-invalid @enderror" rows="5"
                                        placeholder="Masukan keterangan">{{ old('isi_tanggapan') }}</textarea>
                                    @error('isi_tanggapan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
