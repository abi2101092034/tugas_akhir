@extends('warga.layout.master')
@section('title', 'Pengaduan | SILAPOR')
@section('menuLandingPengaduan', 'active')

@section('content')
    <!-- Tour Booking Start -->
    <div class="container-fluid booking py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h5 class="section-booking-title pe-3">Silapor</h5>
                    <h1 class="text-white mb-4">Pengaduan Online</h1>
                    <p class="text-white mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur maxime
                        ullam esse fuga blanditiis accusantium pariatur quis sapiente, veniam doloribus praesentium?
                        Repudiandae iste voluptatem fugiat doloribus quasi quo iure officia.
                    </p>
                    <p class="text-white mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur maxime
                        ullam esse fuga blanditiis accusantium pariatur quis sapiente, veniam doloribus praesentium?
                        Repudiandae iste voluptatem fugiat doloribus quasi quo iure officia.
                    </p>

                </div>
                <div class="col-lg-6">
                    <h1 class="text-white mb-3">
                        <font style="color:#f1c40f ">SI LAPOR!</font>
                    </h1>
                    <p class="text-white mb-4">Silahkan Sampaikan Keluh Kesah anda disini!</p>
                    <form method="POST" action="{{ route('warga-pengaduan.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" name="judul"
                                        class="form-control @error('judul') is-invalid @enderror bg-white border-0"
                                        value="{{ old('judul') }}" placeholder="Nama Lengkap">
                                    <label for="name">Judul Pengaduan</label>
                                    @error('judul')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea name="isi_pengaduan" class="form-control @error('isi_pengaduan') is-invalid @enderror bg-white border-0"
                                        placeholder="Keterangan Pengaduan" style="height: 100px">{{ old('isi_pengaduan') }}</textarea>
                                    <label for="message">Keterangan Pengaduan</label>
                                    @error('isi_pengaduan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea name="lokasi" class="form-control @error('lokasi') is-invalid @enderror bg-white border-0"
                                        placeholder="Keterangan Pengaduan" style="height: 100px">{{ old('lokasi') }}</textarea>
                                    <label for="message">Lokasi Kejadian</label>
                                    @error('lokasi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="date" name="tgl_pengaduan"
                                        class="form-control @error('tgl_pengaduan') is-invalid @enderror bg-white border-0""
                                        value="{{ old('tgl_pengaduan', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                    <label for="message">Tanggal Pengaduan</label>
                                    @error('tgl_pengaduan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="kategori_id" class="form-select bg-white border-0" id="selectedKategori">
                                        <option value="" selected>Pilih Kategori Pengaduan</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama ?? '-' }}</option>
                                        @endforeach
                                    </select>
                                    <label for="select1">Kategori Pengaduan</label>
                                    @error('kategori_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="masalah_id"
                                        class="form-select @error('masalah_id') is-invalid @enderror bg-white border-0"
                                        id="selectedMasalah">
                                        <option value="" selected>Pilih Masalah Pengaduan</option>
                                    </select>
                                    <label for="SelectPerson">Masalah Pengaduan</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="file" name="foto_pengaduan" accept="image/*"
                                    class="form-control @error('foto_pengaduan') is-invalid @enderror bg-white border-0"
                                    style="height: 50px">
                                @error('foto_pengaduan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary text-white w-100 py-3" type="submit">Simpan Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Tour Booking End -->
@endsection
@push('custom-script')
    <script>
        $(document).ready(function() {
            $('#selectedKategori').change(function() {
                var kategoriId = $(this).val();

                // Clear previous options
                $('#selectedMasalah').empty();
                $('#selectedMasalah').append('<option value="" selected>Pilih Masalah Pengaduan</option>');

                if (kategoriId) {
                    $.ajax({
                        url: '/warga-pengaduan/getMasalahPengaduanByKategori/' + kategoriId,
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
