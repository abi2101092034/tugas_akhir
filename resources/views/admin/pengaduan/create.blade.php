@extends('admin.layout.master')
@section('title', 'Pengaduan | SILAPOR')

@section('content')
    <div class="row mb-3">
        <div class="col-lg">
            <h3>Tambah Data Pengaduan</h3>
            <p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="border: none; margin-left: -15px;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('data-pengaduan.index') }}">Data Pengaduan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Data Pengaduan</li>
                </ol>
            </nav>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-pengaduan.index') }}" class="btn btn-primary">
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
                                    <label>Kategori Pengaduan</label>
                                    <select name="kategori_id"
                                        class="form-control @error('kategori_id') is-invalid @enderror" style="width: 100%"
                                        id="selectedKategori">
                                        <option value="" selected>Pilih Kategori Pengaduan</option>
                                        @foreach ($kategoris as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('kategori_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Masalah Pengaduan</label>
                                    <select name="masalah_id" class="form-control @error('masalah_id') is-invalid @enderror"
                                        style="width: 100%" id="selectedMasalah">
                                        <option value="" selected>Pilih Masalah Pengaduan</option>
                                    </select>
                                    @error('masalah_id')
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
                                    <label>Warga</label>
                                    <select name="warga_id" class="form-control @error('warga_id') is-invalid @enderror"
                                        style="width: 100%" id="selectedWarga">
                                        <option value="" selected>Pilih Warga</option>
                                        @foreach ($wargas as $data)
                                            <option value="{{ $data->id }}"
                                                {{ old('warga_id') == $data->id ? 'selected' : '' }}>
                                                {{ $data->nama ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    @error('warga_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="mb-3">
                                    <label>Tanggal Pengaduan</label>
                                    <input type="date" name="tgl_pengaduan"
                                        class="form-control @error('tgl_pengaduan') is-invalid @enderror"
                                        value="{{ old('tgl_pengaduan', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                    @error('tgl_pengaduan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Lokasi</label>
                            <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
                                value="{{ old('lokasi') }}" placeholder="Masukan Lokasi Pengaduan">
                            @error('lokasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Judul</label>
                            <textarea name="judul" class="form-control @error('judul') is-invalid @enderror" rows="5"
                                placeholder="Masukan judul pengaduan">{{ old('judul') }}</textarea>
                            @error('judul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Keterangan</label>
                            <textarea name="isi_pengaduan" class="form-control @error('isi_pengaduan') is-invalid @enderror" rows="5"
                                placeholder="Masukan keterangan">{{ old('isi_pengaduan') }}</textarea>
                            @error('isi_pengaduan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Status Pengaduan</label>
                            <select name="statuspengaduan"
                                class="form-control @error('statuspengaduan') is-invalid @enderror" id="selectedStatus">
                                <option value="" selected>Pilih Status Pengaduan</option>
                                <option value="Sudah Tervalidasi"
                                    {{ old('statuspengaduan') == 'Sudah Tervalidasi' ? 'selected' : '' }}>Sudah Tervalidasi
                                </option>
                                <option value="Belum Tervalidasi"
                                    {{ old('statuspengaduan') == 'Belum Tervalidasi' ? 'selected' : '' }}>Belum Tervalidasi
                                </option>
                            </select>
                            @error('statuspengaduan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Foto Pengaduan</label>
                            <input type="file" name="foto_pengaduan"
                                class="form-control @error('foto_pengaduan') is-invalid @enderror">
                            @error('foto_pengaduan')
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
            $('#selectedMasalah').select2({
                theme: 'bootstrap4',
            });
            $('#selectedWarga').select2({
                theme: 'bootstrap4',
            });
            $('#selectedStatus').select2({
                theme: 'bootstrap4',
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#selectedKategori').change(function() {
                var kategoriId = $(this).val();

                // Clear previous options
                $('#selectedMasalah').empty();
                $('#selectedMasalah').append('<option value="" selected>Pilih Masalah Pengaduan</option>');

                if (kategoriId) {
                    $.ajax({
                        url: '/data-pengaduan/getMasalahPengaduanByKategori/' + kategoriId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#selectedMasalah').append('<option value="' + value
                                    .id + '">' + value.nama + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
