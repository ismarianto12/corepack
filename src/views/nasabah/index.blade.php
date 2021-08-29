@extends('tazamcore::layouts.template')

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


                <div class="card-header">
                    <div class="card-header-action">
                        <a class="btn btn-primary btn-round ml-auto btn-sm" href="{{ route('nasabah.create') }}">
                            <i class="fa fa-plus"></i>
                            Tambah Peserta
                        </a>
                    </div>
                </div>
                <div class="container">
                    <div class="card-body p-0">
                        <table class="table table-sm" id="datatable" style="width:100%">
                            <thead>
                                <th></th>
                                <th>NO APLIKASI</th>
                                <th>NAMA NASABAH</th>
                                <th>PROGRESS</th>
                                <th>P.MANFAAT</th>
                                <th>WAKTU </th>
                                <th>USER MARKETING</th>
                                <th>STATUS</th>
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
        <div class="modal-dialog" role="document" style=" min-width: 100%;">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="title">
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="form_content">
                </div>

            </div>
        </div>
    </div>

    <script>
        $(function() {

            var table = $('#datatable').DataTable({
                // dom: 'Bfrtip',
                // buttons: [{
                //         extend: 'copyHtml5',
                //         className: 'btn btn-info btn-xs'
                //     },
                //     {
                //         extend: 'excelHtml5',
                //         className: 'btn btn-success btn-xs'
                //     },
                //     {
                //         extend: 'csvHtml5',
                //         className: 'btn btn-warning btn-xs'
                //     },
                //     {
                //         extend: 'pdfHtml5',
                //         orientation: 'landscape',
                //         pageSize: 'LEGAL',
                //         className: 'btn btn-prirmay btn-xs'
                //     }
                // ],
                processing: true,
                serverSide: true,
                order: [1, 'asc'],
                pageLength: 10,
                ajax: {
                    url: "{{ route('api.nasabah') }}",
                    method: 'GET',
                    _token: "{{ csrf_token() }}",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        align: 'center',
                        className: 'text-center'
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
                        data: 'progress',
                        name: 'progress'
                    },
                    {
                        data: 'j_penerimanfaat',
                        name: 'j_penerimanfaat'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'user_marketing',
                        name: 'user_marketing'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]

            });
        });

        @include('tazamcore::layouts.tablechecked');

        function del() {
            var c = new Array();
            $("input:checked").each(function() {
                c.push($(this).val());
            });
            if (c.length == 0) {
                $.alert("Silahkan memilih data yang akan dihapus.");
            } else {

                if (c != 'on') {
                    $.post("{{ route('nasabah.destroy', ':id') }}", {
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
        }

        // addd
        $(function() {
            $('#add_data').on('click', function() {
                $('#formmodal').modal('show');
                addUrl = '{{ route('nasabah.create') }}';
                $('#form_content').html('<center><h3>Loading ...</h3></center>').load(addUrl);
            });
            // edit
            $('#datatable').on('click', '#edit', function(e) {
                e.preventDefault();
                $('#formmodal').modal('show');
                id = $(this).data('id');
                addUrl = '{{ route('nasabah.edit', ':id') }}'.replace(':id', id);
                $('#form_content').html(
                    '<center><img src="{{ pkg_asset('tazamcore', 'assets/img/loading.gif') }}" class="img-responsive"></center>'
                ).load(addUrl);

            })
        });
    </script>



@endsection
