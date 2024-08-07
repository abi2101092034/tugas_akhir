@extends('admin.layout.master')
@section('title', 'Data Berita | SILAPOR')

@section('content')
    <div class="row mb-3">
        <div class="col-lg">
            <h3>Tambah Data Berita</h3>
            <p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="border: none; margin-left: -15px;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('data-berita.index') }}">Data Data Berita</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Data Berita</li>
                </ol>
            </nav>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg">
            <form action="{{ route('data-berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('data-berita.index') }}" class="btn btn-primary">
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
                            <label>Kategori Berita</label>
                            <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror"
                                style="width: 100%" id="selectedKategori">
                                <option value="" selected>Pilih Kategori Berita</option>
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
                        <div class="mb-3">
                            <label>Tanggal Publish</label>
                            <input type="date" name="tgl_berita"
                                class="form-control @error('tgl_berita') is-invalid @enderror"
                                value="{{ old('tgl_berita', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                                placeholder="Masukan ID Status">
                            @error('tgl_berita')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Judul Berita</label>
                            <textarea name="judul_berita" class="form-control @error('judul_berita') is-invalid @enderror" rows="5"
                                placeholder="Masukan Judul Berita">{{ old('judul_berita') }}</textarea>
                            @error('judul_berita')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Isi Berita</label>
                            <textarea name="isi_berita" class="form-control @error('isi_berita') is-invalid @enderror" rows="5"
                                placeholder="Masukan Isi Berita" id="isiBeritaId">{{ old('isi_berita') }}</textarea>
                            @error('isi_berita')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Gambar Berita</label>
                            <input type="file" name="foto_berita"
                                class="form-control @error('foto_berita') is-invalid @enderror">
                            @error('foto_berita')
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
    <script>
        ClassicEditor
            .create(document.querySelector('#isiBeritaId'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
