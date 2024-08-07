@extends('admin.layout.master')
@section('title', 'Komentar | SILAPOR')

@section('content')

    <div class="row mb-3">
        <div class="col-lg">
            <h3>Tambah Data Komentar</h3>
            <p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="border: none; margin-left: -15px;">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('data-komentar.index') }}">Data Komentar</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Data Komentar</li>
                </ol>
            </nav>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-komentar.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-komentar.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Simpan Data
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Pengaduan</label>
                                    <select name="pengaduan_id"
                                        class="form-control @error('pengaduan_id') is-invalid @enderror"
                                        id="selectedPengaduan">
                                        <option value="" selected>Pilih Pengaduan</option>
                                        @foreach ($pengaduans as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('pengaduan_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->kode ?? '-' }} - {{ $data->judul ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('pengaduan_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Warga</label>
                                    <select name="warga_id" class="form-control @error('warga_id') is-invalid @enderror"
                                        id="selectedWarga">
                                        <option value="" selected>Pilih Warga</option>
                                        @foreach ($wargas as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('warga_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama ?? '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('warga_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tanggal Komentar</label>
                                    <input type="date" name="tgl_komentar"
                                        class="form-control @error('tgl_komentar') is-invalid @enderror"
                                        value="{{ old('tgl_komentar', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                    @error('tgl_komentar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Komentar</label>
                                    <textarea name="isi_komentar" class="form-control @error('isi_komentar') is-invalid @enderror" rows="5"
                                        placeholder="Masukan komentar">{{ old('isi_komentar') }}</textarea>
                                    @error('isi_komentar')
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
@push('custom-script')
    <script>
        $(document).ready(function() {
            $('#selectedPengaduan').select2({
                theme: 'bootstrap4',
            });
            $('#selectedWarga').select2({
                theme: 'bootstrap4',
            });
        });
    </script>
@endpush
