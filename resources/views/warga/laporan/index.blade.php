@extends('warga.layout.master')
@section('title', 'Laporan | SILAPOR')
@section('menuLandingLaporan', 'active')

@section('content')
    <!-- Navbar & Hero Start -->
    <div class="container-fluid position-relative p-0">
        <div class="carousel-header">
            <div id="carouselId" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carouselId" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carouselId" data-bs-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img src="{{ asset('landing/img/polisi.jpg') }}" class="img-fluid" alt="Image">
                        <div class="carousel-caption">
                            <div class="p-3" style="max-width: 900px;">

                                <h1 class="display-2 text-capitalize text-white mb-4">SI LAPOR!</h1>
                                <p class="mb-5 fs-5">Laporkan Segala Keluh Kesah Anda,Jangan Pernah Takut Untuk Melapor!!!
                                </p>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid about py-5">
        <div class="container py-5">
            <div class="row" id="laporan">
                <div class="col-lg">

                    @foreach ($pengaduans as $data)
                        <div class="card mt-4 shadow">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-lg-1">
                                                    @if (Auth()->user()->foto_profile)
                                                        <img src="{{ asset('storage/' . Auth()->user()->foto_profile) }}"
                                                            style="width: 80px; height: 80px; object-fit: cover;"
                                                            class="rounded-circle" alt="">
                                                    @else
                                                        <img src="{{ asset('images/foto-profile.jpg') }}"
                                                            class="img-fluid rounded-circle" width="80" alt="">
                                                    @endif
                                                </div>
                                                <div class="col-lg">
                                                    <h4>{{ Auth()->user()->name ?? '-' }}</h4>
                                                    <p>{{ Auth()->user()->level->namalevel ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex flex-wrap align-items-center">
                                            <h1 class="mb-0">{{ $data->judul ?? '-' }}</h1>
                                            <span class="ms-2 text-muted">
                                                {{ $data->created_at ? $data->created_at->diffForHumans() : '-' }}</span>
                                        </div>
                                        <p class="my-3"><span class="badge bg-secondary">#{{ $data->kode ?? '-' }}</span>
                                            -
                                            {{ \Carbon\Carbon::parse($data->tgl_pengaduan)->format('d F Y') }}
                                        </p>
                                        <div class="mb-3">
                                            <p>
                                                {{ $data->isi_pengaduan ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg text-end">
                                        <div class="form-group">
                                            @if ($data->statuspengaduan == 'Sudah Tervalidasi')
                                                <span class="badge bg-success">{{ $data->statuspengaduan ?? '-' }}</span>
                                            @elseif($data->statuspengaduan == 'Belum Tervalidasi')
                                                <span class="badge bg-primary">{{ $data->statuspengaduan ?? '-' }}</span>
                                            @elseif($data->statuspengaduan == 'Dikerjakan')
                                                <span class="badge bg-warning">{{ $data->statuspengaduan ?? '-' }}</span>
                                            @elseif($data->statuspengaduan == 'Selesai')
                                                <span class="badge bg-success">{{ $data->statuspengaduan ?? '-' }}</span>
                                            @elseif($data->statuspengaduan == 'Ditolak')
                                                <span class="badge bg-danger">{{ $data->statuspengaduan ?? '-' }}</span>
                                            @else
                                                <span
                                                    class="badge bg-secondary">{{ $data->statuspengaduan ?? 'Belum Tersedia' }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    @if ($data->statuspengaduan == 'Belum Tervalidasi')
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-home-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-home" type="button" role="tab"
                                                aria-controls="pills-home" aria-selected="true">Edit Pengaduan</button>
                                        </li>
                                    @endif
                                    <li class="nav-item comment-btn" role="presentation" id="commentButtonContainer">
                                        <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false">Komentar</button>
                                    </li>
                                    @if ($data->statuspengaduan != 'Belum Tervalidasi')
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                                data-bs-target="#pills-contact" type="button" role="tab"
                                                aria-controls="pills-contact" aria-selected="false">Tanggapan</button>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <form action="{{ route('warga-laporan.update', $data->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="card">
                                            <div class="card-body">
                                                <textarea name="isi_pengaduan" class="form-control @error('isi_pengaduan') is-invalid @enderror" rows="5"
                                                    placeholder="Masukan keterangan">{{ old('isi_pengaduan', $data->isi_pengaduan ?? '-') }}</textarea>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-success">
                                                    Simpan Data
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row mb-4">
                                                <div class="col-lg">
                                                    @foreach ($komentars as $komentar)
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <div class="col-lg-1">
                                                                    @if (Auth()->user()->foto_profile)
                                                                        <img src="{{ asset('storage/' . Auth()->user()->foto_profile) }}"
                                                                            style="width: 80px; height: 80px; object-fit: cover;"
                                                                            class="rounded-circle" alt="">
                                                                    @else
                                                                        <img src="{{ asset('images/foto-profile.jpg') }}"
                                                                            class="img-fluid rounded-circle"
                                                                            width="80" alt="">
                                                                    @endif
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <h4>{{ Auth()->user()->name ?? '-' }}</h4>
                                                                    <p>{{ Auth()->user()->level->namalevel ?? '-' }}</p>
                                                                </div>
                                                                <div class="col-lg text-end">
                                                                    {{ $komentar->created_at ? $komentar->created_at->diffForHumans() : '-' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <p>
                                                                {{ $komentar->isi_komentar ?? '-' }}
                                                            </p>
                                                        </div>
                                                        <hr>
                                                    @endforeach

                                                </div>
                                            </div>
                                            <form action="{{ route('warga-laporan.komentar') }}" method="POST">
                                                @csrf
                                                <input type="text" name="pengaduan_id" class="form-control"
                                                    value="{{ $data->id }}" hidden>
                                                <textarea name="isi_komentar" class="form-control @error('isi_komentar') is-invalid @enderror" rows="5"
                                                    placeholder="Masukan Keterangan komentar">{{ old('isi_komentar') }}</textarea>
                                                @error('isi_komentar')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <button type="submit" class="btn btn-success mt-4">
                                                    Komentar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <ol>
                                                @foreach ($tanggapans as $tanggapan)
                                                    <li>{{ $tanggapan->isi_tanggapan ?? '-' }}</li>
                                                @endforeach
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
