@extends('admin.layout.master')
@section('title', 'Pengaduan | SILAPOR')

@section('content')

    <div class="row mb-3">
        <div class="col-lg">
            <h3>Data Pengaduan</h3>
            <p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="border: none; margin-left: -15px;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Pengaduan</li>
                </ol>
            </nav>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    List Data Pengaduan <span class="badge badge-success">Selesai</span>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Lokasi</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let myTable = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                paging: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100],
                ],
                ajax: {
                    url: "{{ route('data-selesai.index') }}",
                    data: function(d) {
                        d.page = d.start / d.length + 1;
                        d.length = d.length;
                        d.search = d.search.value;
                    },
                    dataSrc: function(response) {
                        return response.data;
                    }
                },
                columns: [{
                        data: 'kode',
                        defaultContent: '-',
                        render: function(data, type, row) {
                            var datas = row.kode;
                            return '<span class="badge badge-primary">' + datas + '</span>';
                        }
                    },
                    {
                        data: 'warga.nama',
                        defaultContent: '-'
                    },
                    {
                        data: 'judul',
                        defaultContent: '-'
                    },
                    {
                        data: 'lokasi',
                        defaultContent: '-'
                    },
                    {
                        data: 'tgl_pengaduan',
                        defaultContent: '-'
                    },
                    {
                        data: 'isi_pengaduan',
                        defaultContent: '-'
                    },
                    {
                        data: 'status',
                        defaultContent: '-',
                        render: function(data, type, row) {
                            var statuss = row.statuspengaduan;
                            if (statuss == 'Belum Tervalidasi') {
                                return '<span class="badge badge-warning">' + statuss + '</span>';
                            } else if (statuss == 'Sudah Tervalidasi') {
                                return '<span class="badge badge-success">' + statuss + '</span>';
                            } else if (statuss == 'Dikerjakan') {
                                return '<span class="badge badge-warning">' + statuss + '</span>';
                            } else if (statuss == 'Selesai') {
                                return '<span class="badge badge-success">' + statuss + '</span>';
                            } else {
                                return '<span class="badge badge-secondary">' + statuss + '</span>';

                            }
                        }
                    },
                    {
                        data: 'foto_pengaduan',
                        defaultContent: '-',
                        render: function(data, type, full, meta) {
                            var fotoProfileDefault = "{{ asset('images/foto-profile.jpg') }}";
                            var fotoDatabase
                            if (data) {
                                fotoDatabase = "{{ asset('storage/') }}" + '/' + data;
                            } else {
                                fotoDatabase = fotoProfileDefault;
                            }
                            return '<img src="' + fotoDatabase +
                                '" alt="Foto Profile" style="width:100px;height:100px;object-fit:cover" />';
                        }
                    }
                ],
                order: [
                    [0, 'desc']
                ],
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            @if (Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
            @endif

            @if (Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @endif
        });
    </script>
    <script>
        // Mendengarkan acara klik tombol hapus
        $(document).on('click', '#hapusData', function(event) {
            event.preventDefault(); // Mencegah perilaku default tombol

            // Ambil URL aksi penghapusan dari atribut 'action' formulir
            var deleteUrl = $(this).closest('form').attr('action');

            // Tampilkan SweetAlert saat tombol di klik
            Swal.fire({
                icon: 'info',
                title: 'Hapus Pengaduan!',
                text: 'Apakah Anda yakin ingin menghapus data ini?',
                showCancelButton: true, // Tampilkan tombol batal
                confirmButtonText: 'Ya',
                confirmButtonColor: '#28a745', // Warna hijau untuk tombol konfirmasi
                cancelButtonText: 'Tidak',
                cancelButtonColor: '#dc3545' // Warna merah untuk tombol pembatalan
            }).then((result) => {
                // Lanjutkan jika pengguna mengkonfirmasi penghapusan
                if (result.isConfirmed) {
                    // Kirim permintaan AJAX DELETE ke URL penghapusan
                    $.ajax({
                        url: deleteUrl,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}" // Kirim token CSRF untuk keamanan
                        },
                        success: function(response) {
                            // Tampilkan pesan sukses jika penghapusan berhasil
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil dihapus.',
                                showConfirmButton: false,
                                timer: 1500 // Durasi pesan success (dalam milidetik)
                            });

                            // Refresh halaman setelah pesan sukses ditampilkan
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        },
                        error: function(xhr, status, error) {
                            // Tampilkan pesan error jika penghapusan gagal
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                showConfirmButton: false,
                                timer: 1500 // Durasi pesan error (dalam milidetik)
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
