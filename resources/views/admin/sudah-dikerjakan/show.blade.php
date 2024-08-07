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

            <div class="card">
                <div class="card-header">
                    <a href="{{ route('data-sudahdikerjakan.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>

                    <a href="{{ route('data-tanggapan.create', ['id' => $pengaduans->id]) }}" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Tanggapan
                    </a>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h6>{{ $pengaduans->warga->nama }}</h6>
                        </div>
                        <hr>
                        <div class="col-12">
                            <h2>{{ $pengaduans->judul }}</h2>
                        </div>
                        <div class="col" style="text-align: right">
                            <p>{{ $pengaduans->tgl_pengaduan }}</p>
                        </div>
                        <div class="col-12" style="text-align: center">
                            <label>Isi Pengaduan</label>
                            <h4 style="text-align: justify">{{ $pengaduans->isi_pengaduan }}</h4><br><br>
                        </div>

                        <div class="col">
                            <label>Lokasi</label>
                            <h5>{{ $pengaduans->lokasi }}</h5>
                        </div>
                        <div class="col">
                            <label>Kategori pengaduan</label>
                            <p>{{ $pengaduans->kategori->nama }}</p>
                        </div>
                        <div class="col">
                            <label>masalah pengaduan</label>
                            <p>{{ $pengaduans->masalah->nama }}</p>
                        </div>
                    </div>


                    {{-- <div class="row">
                        <div class="col-lg">
                            <div class="mb-3">
                                <label>Warga</label>
                                <input type="text" name="warga_id" class="form-control" readonly
                                    value="{{ $pengaduans->warga->nama }}">
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
                                <input type="date" name="tgl_pengaduan" class="form-control" readonly
                                    value="{{ $pengaduans->tgl_pengaduan }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" readonly
                            value="{{ $pengaduans->lokasi }}">
                    </div>
                    <div class="mb-3">
                        <label>Judul</label>
                        <textarea name="judul" class="form-control" readonly>{{ $pengaduans->judul }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Keterangan</label>
                        <textarea name="isi_pengaduan" class="form-control" readonly>{{ $pengaduans->isi_pengaduan }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Status Pengaduan</label>
                        <input type="text" name="statuspengaduan" class="form-control" readonly
                            value="{{ $pengaduans->statuspengaduan }}">
                    </div>
                    <div class="mb-3">
                        <label>Foto Pengaduan</label>
                        <input type="file" name="foto_pengaduan" class="form-control" readonly
                            value="{{ $pengaduans->foto_pengaduan }}">
                        @error('foto_pengaduan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}
                </div>
            </div>

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
