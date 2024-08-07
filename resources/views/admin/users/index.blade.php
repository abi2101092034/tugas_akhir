@extends('admin.layout.master')
@section('title', 'Users Registrasi | SILAPOR')

@section('content')

    <div class="row mb-3">
        <div class="col-lg">
            <h3>Data Users Registrasi</h3>
            <p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="border: none; margin-left: -15px;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Users Registrasi</li>
                </ol>
            </nav>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('data-user.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Tambahkan Users Registrasi
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align:center;">Aksi</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Telepon</th>
                                <th>Gambar</th>
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
                    url: "{{ route('data-user.index') }}",
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
                        'className': 'details-control',
                        'orderable': false,
                        'data': null,
                        'defaultContent': ''
                    },
                    {
                        data: 'name',
                        defaultContent: '-',
                    },
                    {
                        data: 'email',
                        defaultContent: '-'
                    },
                    {
                        data: 'level.namalevel',
                        defaultContent: '-'
                    },
                    {
                        data: 'telp',
                        defaultContent: '-'
                    },
                    {
                        data: 'foto_profile',
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
                initComplete: function(settings, json) {
                    let table = $('#myTable').DataTable();

                    $('#myTable tbody').on('click', 'td.details-control', function() {
                        var tr = $(this).closest('tr');
                        var row = table.row(tr);

                        if (row.child.isShown()) {
                            row.child.hide();
                            tr.removeClass('shown');
                        } else {
                            row.child(format(row.data())).show();
                            tr.addClass('shown');
                        }
                    });

                    $('#btn-show-all-children').on('click', function() {
                        table.rows().every(function() {
                            if (!this.child.isShown()) {
                                this.child(format(this.data())).show();
                                $(this.node()).addClass('shown');
                            }
                        });
                    });

                    $('#btn-hide-all-children').on('click', function() {
                        table.rows().every(function() {
                            if (this.child.isShown()) {
                                this.child.hide();
                                $(this.node()).removeClass('shown');
                            }
                        });
                    });

                    var editRoute = "{{ route('data-user.edit', ':id') }}"
                    var deleteRoute = "{{ route('data-user.destroy', ':id') }}";

                    function format(d) {
                        // d is the original data object for the row

                        var editUrl = editRoute.replace(':id', d.id);
                        var deleteUrl = deleteRoute.replace(':id', d.id);
                        return '<table>' +
                            '<tr>' +
                            '<td>Edit Users Registrasi :</td>' +
                            '<td><a href="' + editUrl +
                            '"class="btn btn-info"><i class="fa fa-edit"></i> &nbsp; Edit Users Registrasi</a></td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>Hapus Users Registrasi</td>' +
                            '<td><form action="' + deleteUrl + '" method="POST" id="dataForm">' +
                            '@csrf' +
                            '<button type="submit" class="btn btn-danger" id="hapusData"><i class="fa fa-times"></i> &nbsp; Hapus Users Registrasi</button>' +
                            '</form></td>' +
                            '</tr>' +
                            '</table>';
                    }
                }
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
                title: 'Hapus Users Registrasi!',
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
