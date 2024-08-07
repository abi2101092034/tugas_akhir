@extends('admin.layout.master')
@section('title', 'Status Autentikasi | SILAPOR')

@section('content')

    <div class="row mb-3">
        <div class="col-lg">
            <h3>Data Status Autentikasi</h3>
            <p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="border: none; margin-left: -15px;">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Status Autentikasi</li>
                </ol>
            </nav>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('data-level.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Tambahkan Status Autentikasi
                    </a>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align:center;">Aksi</th>
                                <th style="width: 5%; text-align:center;">ID</th>
                                <th>Nama Status</th>
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
                    url: "{{ route('data-level.index') }}",
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
                        data: 'id_level',
                        defaultContent: '-',
                    },
                    {
                        data: 'namalevel',
                        defaultContent: '-'
                    },
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

                    var editRoute = "{{ route('data-level.edit', ':id') }}"
                    var deleteRoute = "{{ route('data-level.destroy', ':id') }}";

                    function format(d) {
                        // d is the original data object for the row

                        var editUrl = editRoute.replace(':id', d.id);
                        var deleteUrl = deleteRoute.replace(':id', d.id);
                        return '<table>' +
                            '<tr>' +
                            '<td>Edit Status Autentikasi :</td>' +
                            '<td><a href="' + editUrl +
                            '"class="btn btn-info"><i class="fa fa-edit"></i> &nbsp; Edit Status Autentikasi</a></td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td>Hapus Status Autentikasi</td>' +
                            '<td><form action="' + deleteUrl + '" method="POST" id="dataForm">' +
                            '@csrf' +
                            '<button type="submit" class="btn btn-danger" id="hapusData"><i class="fa fa-times"></i> &nbsp; Hapus Status Autentikasi</button>' +
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
                title: 'Hapus Status Autentikasi!',
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
