@extends('ismarianto::layouts.template')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-action">

                        <button class="btn btn-warning" id="refresh_tablenya"><i class="fas fa-refresh"></i>Segarkan
                            data</button>
                    </div>
                </div>

                {!! PhareSpase::load_css([asset('vendor/ismarianto/dash/dependencies/datatables/css/dataTables.bootstrap4.min.css')]) !!}

                {!! PhareSpase::load_js([asset('vendor/ismarianto/dash/dependencies/datatables/js/jquery.dataTables.min.js'), asset('vendor/ismarianto/dash/dependencies/datatables/js/dataTables.bootstrap4.min.js')]) !!}

                <div class="card-body p-0">
                    <div class="container">
                        <table class="table table-sm" id="datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NO APLIKASI</th>
                                    <th>NAMA NASABAH</th>
                                    <th>PENERIMA MANFAAT</th>
                                    <th>WAKTU INPUT </th>
                                    <th>PROGRESS</th>
                                    <th>STATUS</th>
                                    <th>USER MKT</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
@section('script')

    <!-- Modal -->
    <div class="modal fade" id="formmodal" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 40%;padding-left: 17px; overflow: auto;">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="title">
                    </h5>
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="form_content">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-info btn-lg" id="close"><i class="fas fa-close"></i>Tutup halaman
                        ini
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var table = $('#datatable').DataTable({

            processing: true,
            serverSide: true,
            order: [1, 'asc'],
            pageLength: 10,
            ajax: {
                url: "{{ route('api.uploaddankelengkapan') }}",
                method: 'GET',
                _token: "{{ csrf_token() }}",
            },
            columns: [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'no_aplikasi',
                    name: 'no_aplikasi'
                },
                {
                    data: 'nama_sesuai_ktp',
                    name: 'nama_sesuai_ktp'
                },
                {
                    data: 'j_manfaat',
                    name: 'j_manfaat',
                },
                {
                    data: 'waktu_input',
                    name: 'waktu_input'
                },
                {
                    data: 'progress',
                    name: 'progress'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'user_id',
                    name: 'user_id'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
        @include('ismarianto::layouts.tablechecked');

        function del() {
            var c = new Array();
            $("input:checked").each(function() {
                c.push($(this).val());
            });
            if (c.length == 0) {
                $.alert("Silahkan memilih data yang akan dihapus.");
            } else {
                $.post("{{ route('modul.destroy', ':id') }}", {
                    '_method': 'DELETE',
                    'id': c
                }, function(data) {
                    $('#datatable').DataTable().ajax.reload();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Data berhasil di hapus',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }, "JSON").fail(function(data) {
                    $('#datatable').DataTable().ajax.reload();

                    err = '';
                    respon = data.responseJSON;
                    $.each(respon.errors, function(index, value) {
                        err += "<li>" + value + "</li>";
                    });

                    $.notify({
                        icon: 'flaticon-alarm-1',
                        title: 'Akses tidak bisa',
                        message: err,
                    }, {
                        type: 'secondary',
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        time: 3000,
                        z_index: 2000
                    });
                });
            }
        }

        function kirimdata(url) {
            event.preventDefault();
            $('#formmodal').modal('show', {
                backdrop: 'static',
                keyboard: false
            });
            $('#form_content').html('<center><h3>Load data ...</h3></center>').load(url);
        }
        // addd
        $(function() {
            // edit
            $('#datatable').on('click', '#lengkapi', function(e) {
                e.preventDefault();
                $('#formmodal').modal('show', {
                    backdrop: 'static',
                    keyboard: false
                });
                id = $(this).data('id');
                addUrl = '{{ route('uploaddankelengkapan.edit', ':id') }}'.replace(':id', id);
                $('#form_content').html(
                    '<center><img src="{{ pkg_asset('ismarianto', 'assets/img/loading.gif') }}" class="img-responsive"></center>'
                ).load(addUrl);

            })
        });
    </script>

@endsection
