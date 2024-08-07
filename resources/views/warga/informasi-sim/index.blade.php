@extends('warga.layout.master')
@section('title', 'Pengaduan | SILAPOR')
@section('menuLandingInformasi', 'active')
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

    <hr>
    <div class="container-fluid" id="sim">
        <div class="row">
            <div class="col">
                <div style="text-align: justify" class="content">
                    <p>
                    <ol>

                        <h2 style="text-align: center">
                            <font color="blue">PERSYARATAN UNTUK MEMBUAT SIM
                            </font>
                        </h2>
                        <br>
                        <h2>
                            <font color="blue"> Cara Membuat SIM di Kantor Polisi</font>
                        </h2>

                        <ul>
                            <li>
                                <h5> Kunjungi Satpas, SIM Corner, atau mobil SIM keliling
                                    terdekat sesuai dengan lokasi tempat tinggal Anda.</h5>
                            </li>
                            <li>
                                <h5> Siapkan semua dokumen yang diperlukan
                                    untuk memenuhi persyaratan perpanjangan SIM. Pastikan tidak ada yang terlewat.</h5>
                            </li>
                            <li>
                                <h5> Isi formulir
                                    permohonan perpanjangan SIM.</h5>
                            </li>
                            <li>
                                <h5> Lakukan pembayaran biaya perpanjangan SIM sesuai dengan jenis
                                    SIM yang Anda perpanjang.</h5>
                            </li>
                            <li>
                                <h5> Lakukan proses perekaman sidik jari dan foto.</h5>
                            </li>
                            <li>
                                <h5>Tunggu sebentar
                                    hingga petugas memberikan SIM baru Anda.</h5>
                            </li>

                        </ul>
                        <h5> Jika blanko SIM kosong, Anda akan diberitahu tentang
                            jadwal pengambilan SIM.</h5>

                        <h2>
                            <font color="blue">SYARAT MEMBUAT SIM</font>
                        </h2>
                        <ul>
                            <li>
                                <h5>Usia minimal 17 tahun</h5>
                            </li>
                            <li>
                                <h5> Pas foto</h5>
                            </li>
                            <li>
                                <h5>KTP asli dan fotokopi KTP sebanyak 4 lembar.</h5>
                            </li>

                        </ul>

                        <h2>
                            <font style="color: blue">Cara membuat SIM Online</font>
                        </h2>
                        <h5> Anda juga dapat memperpanjang SIM tanpa perlu mengunjungi kantor polisi.<br> Cukup dengan
                            mengaksesnya melalui perangkat gawai atau smartphone<br>
                            Berikut langkah-langkahnya:
                        </h5>
                        <ul>
                            <li>
                                <h5> Kunjungi situs pelayanan SIM<br>
                                    Kunjungi situs <a
                                        href="http://sim.korlantas.polri.go.id/devregistrasi/index.php/registrasi/login">
                                        http://sim.korlantas.polri.go.id</a>
                                    di smartphone atau gawai Bila ingin melakukan perpanjangan SIM secara daring
                                    dapat menggunakan aplikasi,<br> cukup unduh aplikasi Digital Korlantas POLRI melalui
                                    Play
                                    Store.
                                </h5>

                            </li>

                            <li>
                                <h5> Registrasi SIM online<br>
                                    Kemudian ke tahap registrasi SIM online dengan klik menu register atau pendaftaran dan
                                    pilih "Perpanjang SIM" pada menu yang tersedia</h5>

                            </li>

                            <li>
                                <h5> Isi formulir<br> Setelah itu, pengguna akan diminta untuk
                                    mengisi semua informasi yang diminta pada formulir online dan memasukkan kode verifikasi
                                    sesuai dengan yang tertera.<br> Setelah selesai, klik "kirim". Tunggu sejenak hingga
                                    Anda menerima notifikasi melalui email<br> yang memberitahu bahwa registrasi telah
                                    berhasil
                                    dilakukan, beserta kode
                                    tagihan untuk
                                    pembayaran perpanjangan SIM.</h5>

                            </li>
                            <li>
                                <h5> Pembayaran<br>
                                    Selanjutnya lakukan pembayaran dan pastikan untuk menyimpan
                                    bukti pembayaran tersebut agar diberikan kepada petugas.<br> Setelah itu, Anda dapat
                                    mengunjungi Satpas,<br> SIM Corner, atau Simling untuk mengambil SIM yang telah
                                    diperpanjang.<br> Pastikan untuk
                                    membawa seluruh dokumen persyaratan perpanjangan SIM, serta bukti pembayaran dan
                                    registrasi.</h5>


                            </li>
                            <li>
                                <h5> Mengikuti ujian teori</h5>
                            </li>
                            <li>
                                <h5>Apabila sudah lulus ujian teori, selanjutnya mengikuti ujian praktik</h5>
                            </li>
                            <li>
                                <h5>Jika ujian praktik dinyatakan lulus, petugas akan memproses SIM yang ada butuhkan.
                                </h5>
                            </li>
                        </ul><br>
                        <h2>
                            <font color="blue">Biaya Pembuatan sim</font>
                        </h2>
                        <h5> Setelah menyerahkan
                            semua dokumen kepada petugas, lakukan proses perekaman sidik jari dan foto untuk SIM baru
                            Anda.<br>
                            Tunggu hingga nama Anda dipanggil oleh petugas untuk mengambil SIM yang telah diperpanjang.</h5>

                        <h5> Berdasarkan Peraturan Pemerintah Nomor 60 Tahun 2016, berikut adalah besaran biaya untuk<br>
                            melakukan pembuatan SIM berdasarkan klasifikasinya:<br>
                        </h5>
                        <ul>
                            <li>
                                <h5> SIM A : Rp120.000</h5>
                            </li>
                            <li>
                                <h5> SIM B1 : Rp120.000</h5>
                            </li>
                            <li>
                                <h5> SIM B2 : Rp120.000</h5>
                            </li>
                            <li>
                                <h5>
                                    SIM C : Rp 100.000</h5>
                            </li>
                            <li>
                                <h5> SIM C I : Rp 100.000</h5>
                            </li>
                            <li>
                                <h5> SIM C II : Rp 100.000</h5>
                            </li>
                            <li>
                                <h5>
                                    SIM D : Rp50.000</h5>
                            </li>
                        </ul>
                        <h5>
                            Demikian syarat dan cara bikin SIM bulan ini. Ada baiknya untuk berlatih dan belajar sebelum
                            mengajukan pembuatan SIM baru.
                        </h5>

                    </ol>


                </div>
            </div>
        </div>
    </div>
    <hr>
@endsection
