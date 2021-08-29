@extends('ismarianto::layouts.template')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <div class="card-header-action">
                        <button class="btn btn-warning" id="refresh_tablenya"><i class="fas fa-refresh"></i>Segarkan
                            data</button>

                        <button class="btn btn-primary btn-round ml-auto btn-sm" id="add_data">
                            <i class="fa fa-plus"></i>
                            Tambah Data
                        </button>
                        <button class="btn btn-danger btn-round btn-sm" id="add_data" onclick="javascript:confirm_del()">
                            <i class="fa fa-minus"></i>
                            Delete selected
                        </button>
                    </div>
                </div>
                {!! PhareSpase::load_css([asset('vendor/ismarianto/dash/dependencies/datatables/css/dataTables.bootstrap4.min.css')]) !!}

                {!! PhareSpase::load_js([asset('vendor/ismarianto/dash/dependencies/datatables/js/jquery.dataTables.min.js'), asset('vendor/ismarianto/dash/dependencies/datatables/js/dataTables.bootstrap4.min.js')]) !!}

                <div class="card-body p-0">
                    <div class="container">
                        <table class="table table-sm" id="datatable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Kode Program</th>
                                    <th>Nama Program</th>
                                    <th>Nilai Manfaat</th>
                                    <th>Setoran Awal</th>
                                    <th>Setoran Rutin</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script>
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
                url: "{{ route('api.parameter') }}",
                method: 'GET',
                _token: "{{ csrf_token() }}",
            },
            columns: [

                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'kode_prog',
                    name: 'kode_prog'
                },
                {
                    data: 'nama_prog',
                    name: 'nama_prog'
                },
                {
                    data: 'nilai_manfaat_hadiah',
                    render: $.fn.dataTable.render.number('.', '.', 2, ''),
                    name: 'nilai_manfaat_hadiah'
                },

                {
                    data: 'setoran_awal',
                    render: $.fn.dataTable.render.number('.', '.', 2, ''),
                    name: 'setoran_awal'
                },
                {
                    data: 'setoran_rutin',
                    render: $.fn.dataTable.render.number('.', '.', 2, ''),
                    name: 'setoran_rutin'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]

        });
        @include('ismarianto::layouts.tablechecked');
        // addd
        $(function() {
            $('#add_data').on('click', function() {
                $('#formmodal').modal('show');
                addUrl = '{{ route('parameter.create') }}';
                $('#form_content').html('<center><h3>Loading Form Harap Bersabar ...</h3></center>').load(
                    addUrl);
            });
            $('#datatable').on('click', '#edit', function(e) {
                e.preventDefault();
                $('#formmodal').modal('show');
                id = $(this).data('id');
                addUrl = '{{ route('parameter.edit', ':id') }}'.replace(':id', id);
                $('#form_content').html('<center><h3>Loading Form Harap Bersabar ...</h3></center>').load(
                    addUrl);

            });
        });

        function del() {
            var c = new Array();
            $("input:checked").each(function() {
                c.push($(this).val());
            });
            if (c.length == 0) {
                $.alert("Silahkan memilih data yang akan dihapus.");
            } else {
                $.post("{{ route('parameter.destroy', ':id') }}", {
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



        function actived(p, id) {
            event.preventDefault();
            $.confirm({
                title: '',
                content: 'Apakah Anda yakin akan set status program?',
                icon: 'icon icon-question amber-text',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    ok: {
                        text: 'ok!',
                        btnClass: 'btn-primary',
                        keys: ['enter'],
                        action: function() {
                            $.post('{{ route('parameter.setactive') }}', {
                                id: id,
                                active: p

                            }, function(data) {
                                $('#datatable').DataTable().ajax.reload();

                            });

                        }
                    }
                }
            });
        }
    </script>


@endsection
