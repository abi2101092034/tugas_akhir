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
    <div class="container-fluid" id="informasi">
        <div class="row">
            <div class="col">
                <div style="text-align: justify
                " class="content">
                    <p>
                    <ol>

                        <h2 style="text-align: center">
                            <font color="blue">PERSYARATAN UNTUK MENGAJUKAN SKCK BARU BAGI<br> WARGA NEGARA INDONESIA(WNI)
                            </font>
                        </h2>
                        <br>
                        <h5>Berikut Adalah beberapa persayartan mengajukan SKCK bagi warga negara Indonesia:</h5>
                        <ul>
                            <li>
                                <h5>Fotokopi Kartu Tanda Penduduk (KTP) (membawa KTP asli untuk verifikasi)</h5>
                            </li>
                            <li>
                                <h5> Fotokopi Kartu Keluarga (KK).</h5>
                            </li>
                            <li>
                                <h5>Surat Pengantar dari kelurahan/Camat</h5>
                            </li>
                            <li>
                                <h5> Fotokopi akta kelahiran atau kenal lahir.</h5>
                            </li>
                            <li>
                                <h5> Fotokopi kartu identitas lain jika belum memenuhi persyaratan untuk mendapatkan KTP.
                                </h5>
                            </li>
                            <li>
                                <h5> Enam lembar pas foto berwarna ukuran 4x6 cm dengan latar belakang merah,<br> pemohon
                                    harus
                                    berpakaian
                                    sopan dan
                                    berkerah, tidak menggunakan aksesori di wajah, dan wajah harus terlihat utuh bagi
                                    pemohon
                                    yang
                                    menggunakan
                                    jilbab.
                                </h5>
                            </li>
                        </ul>
                    </ol>

                    <ol>

                        <h4>
                            <font color="blue">SYARAT PEMBUATAN SKCK DI POLSEK BAGI WNA<font>
                        </h4>

                        <h5> Inilah beberapa persyaratan untuk mengajukan SKCK bagi Warga Negara Asing (WNA)
                            yang disponsori,<br>dipekerjakan, atau bertanggung jawab oleh suatu perusahaan atau lembaga:
                        </h5>
                        <br>

                        <ul>
                            <li>
                                <h5>Surat permohonan dari sponsor, perusahaan, atau lembaga yang mempekerjakan, menggunakan,
                                    atau
                                    yang
                                    bertanggung jawab pada WNA.</h5>
                            </li>
                            <li>
                                <h5>
                                    Fotokopi Kartu Tanda Penduduk (KTP) dan Surat Nikah jika sponsor adalah Suami/Istri
                                    Warga
                                    Negara
                                    Indonesia
                                    (WNI).</h5>
                            </li>
                            <li>
                                <h5>Fotokopi paspor.</h5>
                            </li>
                            <li>
                                <h5> Fotokopi Kartu Izin Tinggal Terbatas (KITAS) atau Kartu Izin Tinggal Tetap (KITAP).
                                </h5>
                            </li>
                            <li>
                                <h5>Fotokopi Izin Mempekerjakan Tenaga Kerja Asing (IMTA) dari Kementerian Ketenagakerjaan
                                    RI.
                                </h5>
                            </li>
                            <li>
                                <h5>Fotokopi Surat Tanda Melapor (STM) dari Kepolisian.</h5>
                            </li>
                            <li>
                                <h5> Enam lembar pas foto berwarna dengan ukuran 4x6 cm, latar belakang merah, <br>pemohon
                                    berpakaian
                                    sopan
                                    dan berkerah, tanpa aksesori di wajah, dan wajah harus terlihat utuh bagi pemohon yang
                                    mengenakan
                                    jilbab.
                                </h5>
                            </li>
                        </ul>


                        <h5> Untuk mendapatkan Surat Keterangan Catatan Kepolisian (SKCK), individu dapat mengunjungi kantor
                            polisi
                            (Polsek)secara langsung atau memilih opsi pembuatan secara online.<br> Selain itu, terdapat
                            perbedaan
                            dalam
                            proses pembuatan SKCK baru dan perpanjangan masa berlaku SKCK.</h5><br>
                    </ol>
                    <ol type="2">

                        <h4>
                            <font color="blue">Prosedur Pembuatan SKCK secara Offline<font>
                        </h4>


                        <h5> Inilah langkah-langkah lengkap untuk membuat Surat Keterangan Catatan Kepolisian (SKCK) di
                            kantor
                            polisi
                            atau secara offline:</h5><br>
                        <ul>
                            <li>
                                <h5> Sertakan Surat Pengantar dari Kantor Kelurahan yang mencantumkan domisili pendaftar
                                    secara
                                    jelas
                                    dan tepat.</h5>
                            </li>
                            <li>
                                <h5> Bawa fotokopi KTP atau SIM yang masih berlaku dan sesuai dengan domisili yang tercantum
                                    pada
                                    Surat
                                    Pengantar.</h5>
                            </li>
                            <li>
                                <h5>Sertakan fotokopi Kartu Keluarga sebagai bukti alamat dan hubungan keluarga.</h5>
                            </li>
                            <li>
                                <h5>Bawa fotokopi Akta Kelahiran atau Kenal Lahir untuk verifikasi data identitas pendaftar.
                                </h5>
                            </li>
                            <li>
                                <h5> Siapkan 6 lembar pasfoto terbaru berwarna dengan ukuran 4×6, pastikan wajah terlihat
                                    jelas
                                    dan
                                    latar belakang netral.</h5>
                            </li>
                            <li>
                                <h5> Isi Formulir Daftar Riwayat Hidup dengan lengkap, mencakup riwayat pendidikan,
                                    pekerjaan,
                                    dan
                                    informasi pribadi lainnya yang diminta.</h5>
                            </li>
                            <li>
                                <h5>
                                    Setelah mengisi formulir, pendaftar akan diminta untuk melakukan pengambilan sidik jari
                                    oleh
                                    petugas
                                    yang bertugas,<br> tahap ini adalah tahap terpenting untuk keperluan identifikasi.</h5>
                            </li>
                        </ul>
                    </ol>

                    <ol>
                        <h4>
                            <font color="blue">Prosedur Perpanjangan SKCK Offline</font>
                        </h4>
                        <h5> Penting untuk diingat bahwa Surat Keterangan Catatan Kepolisian (SKCK) memiliki masa berlaku
                            hanya
                            selama 6 bulan setelah diterbitkan.<br> Jika pendaftar memerlukan SKCK sebelum masa berlakunya
                            habis,
                            maka harus mengajukan perpanjangan.<br> Berikut adalah langkah-langkah untuk memperpanjang masa
                            berlaku
                            SKCK:
                        </h5>

                        <ul>
                            <li>
                                <h5> Bawa lembar SKCK yang sudah lama dimiliki, pastikan dokumen ini masih dalam masa
                                    berlaku
                                    atau belum habis masa berlakunya lebih dari 1 tahun.</h5>
                            </li>
                            <li>
                                <h5> Persiapkan fotokopi KTP atau SIM yang masih berlaku sebagai identifikasi diri.</h5>
                            </li>
                            <li>
                                <h5> Sertakan fotokopi Kartu Keluarga sebagai bukti alamat dan hubungan keluarga.</h5>
                            </li>
                            <li>
                                <h5>
                                    Siapkan fotokopi Akta Kelahiran atau Kenal Lahir sebagai tambahan identifikasi.</h5>
                            </li>
                            <li>
                                <h5> Sediakan 3 lembar pasfoto terbaru berukuran 4×6 dengan latar belakang yang netral dan
                                    wajah
                                    yang jelas
                                    terlihat.</h5>
                            </li>
                            <li>
                                <h5>Isi formulir perpanjangan SKCK yang tersedia di kantor Polisi dengan lengkap dan akurat
                                    sesuai petunjuk yang
                                    diberikan.</h5>
                            </li>
                        </ul><br>

                        <h4>
                            <font color="blue">Prosedur Pembuatan SKCK Online</font>
                        </h4>
                        <h5>Langkah-langkah membuat Surat Keterangan Catatan Kepolisian (SKCK) secara online melalui situs
                            resmi
                            Polri
                            adalah sebagai berikut:</h5>

                        <ul>
                            <li>
                                <h5> Kunjungi situs pendaftaran permohonan SKCK online yang disediakan oleh Polri.<br>Proses
                                    pengisian data dan unggah dokumen dilakukan melalui platform daring ini.</h5>
                            </li>
                            <li>
                                <h5> Situs SKCK online dapat diakses melalui laman <a target="_blank"
                                        href="https://skck.polri.go.id/">
                                        <font style="color: #fa8231">https://skck.polri.go.id/</font>
                                    </a>
                                </h5>
                            </li>
                            <li>
                                <h5>Warga yang ingin membuat SKCK secara online diminta untuk mengisi formulir pendaftaran
                                    yang
                                    tersedia di situs tersebut.</h5>
                            </li>
                            <li>
                                <h5> Sebelum mengisi formulir, warga harus memutuskan untuk keperluan apa SKCK tersebut
                                    dibuat,
                                    seperti keperluan kerja,<br> pendidikan, atau keperluan lainnya yang sesuai dengan
                                    ketentuan
                                    yang berlaku.
                                </h5>
                            </li>

                        </ul><br>

                        <h4>
                            <font color="blue">Biaya</font>
                        </h4>

                        <h5> Biaya pembuatan Surat Keterangan Catatan Kepolisian (SKCK) ditetapkan berdasarkan beberapa
                            dasar
                            aturan,antara lain:</h5>

                        <ul>
                            <li>
                                <h5> Undang-Undang Republik Indonesia Nomor 20 Tahun 1997 tentang Penerimaan Bukan Pajak
                                    (PNBP).
                                </h5>
                            </li>
                            <li>
                                <h5> Undang-Undang Republik Indonesia Nomor 2 Tahun 2002 tentang Kepolisian Negara Republik
                                    Indonesia.</h5>
                            </li>
                            <li>
                                <h5>Peraturan Pemerintah Republik Indonesia Nomor 50 Tahun 2010 tentang Tarif atas Jenis
                                    Penerimaan Bukan Pajak
                                    yang berlaku pada instansi Polri.</h5>
                            </li>
                            <li>
                                <h5> Surat Telegram Kapolri Nomor ST/1928/VI/2010 tanggal 23 Juni 2010 yang mengatur
                                    pemberlakuan Peraturan
                                    Pemerintah Nomor 50 Tahun 2010.</h5>
                            </li>
                            <li>
                                <h5> Peraturan Pemerintah Republik Indonesia Nomor 60 Tahun 2016 tentang Jenis dan Tarif
                                    atas
                                    Jenis Penerimaan
                                    Negara Bukan Pajak yang Berlaku pada Kepolisian Negara Republik Indonesia.</h5>
                            </li>
                            <li>
                                <h5> Sesuai dengan informasi yang diambil dari situs resmi Polri, biaya pembuatan SKCK
                                    adalah
                                    sebesar Rp 30.000.</h5>
                            </li>
                        </ul>
                    </ol>

                    </p>
                </div>
            </div>
        </div>
    </div>
    <hr>
@endsection
