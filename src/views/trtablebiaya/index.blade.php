@extends('tazamcore::layouts.template')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-action">
                        <button class="btn btn-primary btn-round ml-auto btn-sm" id="add_data">
                            <i class="fa fa-plus"></i>
                            Add Row
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
                        <div class="form-group row">
                            <label for="data" class="col-md-2 text-left">Parameter Program</label>
                            <div class="col-md-4">
                                <select class="form-control select2" data="tmparameter_id" id="tmparameter_id">
                                    <option value="">Pilih Parameter Program</option>
                                    @foreach ($tmparemater as $tmparamters)
                                        <option value="{{ $tmparamters->id }}">{{ $tmparamters->nama_prog }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr />
                        <table class="table table-sm" id="datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <i class="fas fa-th"></i>
                                    </th>
                                    <th>Parameter </th>
                                    <th>Dari bulan </th>
                                    <th>Ke bulan </th>
                                    <th>Nominal </th>
                                    <th>Users </th>
                                    <th>Create </th>
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
        <div class="modal-dialog" role="document" style=" min-width: 65%;">
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
            processing: true,
            servecrSide: true,
            order: [1, 'asc'],
            pageLength: 10,
            ajax: {
                url: "{{ route('api.trtablebiaya') }}",
                method: 'post',
                _token: "{{ csrf_token() }}",
                data: function(data) {
                    data.tmparameter_id = $('#tmparameter_id').val();
                }
            },
            columns: [{
                    data: 'id',
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    align: 'center',
                    className: 'text-center'
                },
                {
                    data: 'parameter',
                    orderable: false,
                    searchable: false,

                },
                {
                    data: 'dari_bulan',
                    orderable: false,
                    searchable: false,

                },
                {
                    data: 'ke_bulan',
                    orderable: false,
                    searchable: false,

                },
                {
                    data: 'nominal',
                    render: $.fn.dataTable.render.number('.', '.', 2, ''),
                    orderable: false,
                    searchable: false,

                },
                {
                    data: 'users_id',
                    orderable: false,
                    searchable: false,

                },
                {
                    data: 'action',
                    data: 'action'
                }
            ]

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
                $.post("{{ route('trtablebiaya.destroy', ':id') }}", {
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
        $(function() {
            $('.selec2').select2();
            $('#tmparameter_id').on('change', function() {
                $('#datatable').DataTable().ajax.reload();
            });

            $('#add_data').on('click', function() {
                $('#formmodal').modal('show');
                addUrl = '{{ route('trtablebiaya.create') }}';
                $('#form_content').html('<center><h3>Loading ...</h3></center>').load(addUrl);
            });

            // edit
            $('#datatable').on('click', '#edit', function(e) {
                e.preventDefault();
                $('#formmodal').modal('show');
                id = $(this).data('id');
                addUrl = '{{ route('trtablebiaya.edit', ':id') }}'.replace(':id', id);
                $('#form_content').html(
                    '<center><img src="{{ pkg_asset('tazamcore', 'assets/img/loading.gif') }}" class="img-responsive"></center>'
                ).load(
                    addUrl);

            })
        });
    </script>



@endsection
