@extends('tazamcore::layouts.template')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                {!! PhareSpase::load_css([asset('vendor/ismarianto/dash/dependencies/datatables/css/dataTables.bootstrap4.min.css')]) !!}

                {!! PhareSpase::load_js([asset('vendor/ismarianto/dash/dependencies/datatables/js/jquery.dataTables.min.js'), asset('vendor/ismarianto/dash/dependencies/datatables/js/dataTables.bootstrap4.min.js')]) !!}



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

                <div class="container">

                    <br />
                    <div class="form-group row">
                        <label for="data" class="col-md-2 text-left">Parameter Program</label>
                        <div class="col-md-4">
                            <select class="form-control " data="tmparameter_id" id="tmparameter_id">
                                <option value="">Jenis Parameter</option>
                                @foreach ($tmparemater as $tmparamters)
                                    <option value="{{ $tmparamters->id }}">{{ $tmparamters->nama_prog }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label for="data" class="col-md-2 text-left">Hadiah</label>
                        <div class="col-md-4">
                            <select class="form-control " data="tmhadiah_id" id="tmhadiah_id">
                                <option value="">Jenis Hadiah</option>
                                @foreach ($tmhadiah as $tmhadiahs)
                                    <option value="{{ $tmhadiahs->id }}">{{ $tmhadiahs->jenis_hadiah }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label for="data" class="col-md-2 text-left">Document Status</label>
                        <div class="col-md-4">
                            <select class="form-control" id="category">
                                <option value="">Kategori Doc</option>
                                @php
                                    $f = [
                                        'document' => 'Document Kelengkapan Nasabah',
                                        'jaminan' => 'Document Jaminan Nasabah',
                                    ];
                                @endphp
                                @foreach ($f as $fs => $g)
                                    <option value="{{ $fs }}">{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="xx23"></div>
                    <div class="card-body p-0">
                        <table class="table table-sm" id="datatable">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <i class="fas fa-th"></i>
                                    </th>
                                    <th>Nama Document</th>
                                    <th>Peruntukan</th>
                                    <th>Status Document</th>
                                    <th>Jenis Hadiah</th>
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
        <div class="modal-dialog" role="document" style=" min-width: 80%;">
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
        $(function() {

            var table = $('#datatable').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        className: 'btn btn-info btn-xs'
                    },
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-success btn-xs'
                    },
                    {
                        extend: 'csvHtml5',
                        className: 'btn btn-warning btn-xs'
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        className: 'btn btn-prirmay btn-xs'
                    }
                ],
                processing: true,
                serverSide: true,
                order: [1, 'asc'],
                pageLength: 10,
                ajax: {
                    url: "{{ route('api.trparameter_doc') }}",
                    method: 'POST',
                    _token: "{{ csrf_token() }}",
                    data: function(data) {
                        data.tmparameter_id = $('#tmparameter_id').val();
                        data.tmhadiah_id = $('#tmhadiah_id').val();
                        data.category = $('#category').val();

                    },
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        align: 'center',
                        className: 'text-center'
                    },
                    {
                        data: 'nama_doc',
                        name: 'nama_doc'
                    },
                    {
                        data: 'jenisnya',
                        name: 'jenisnya'
                    },

                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
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
                $.post("{{ route('trparameter_doc.destroy', ':id') }}", {
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

        // addd
        $(function() {


            $('#tmparameter_id, #tmhadiah_id, #category').on('change', function(data) {
                if ($(this).val() == '') {
                    $('#tmhadiah_id').val('');
                    $('#category').val('');
                } else {
                    $('#datatable').DataTable().ajax.reload();
                }
            });
            $('#category').on('change', function(data) {
                // $(this.val() == '')
                var text = $(this).find(":selected").text();
                $('#xx23').html('<div class="alert alert-info">' + text +
                    '</div>');
            });


            $('#add_data').on('click', function() {
                $('#formmodal').modal('show');
                addUrl = '{{ route('trparameter_doc.create') }}';
                $('#form_content').html(
                    '<center><img src="{{ pkg_asset('tazamcore', 'assets/img/loading.gif') }}" class="img-responsive"></center>'
                ).load(addUrl);
            });
            // edit
            $('#datatable').on('click', '#edit', function(e) {
                e.preventDefault();
                $('#formmodal').modal('show');
                id = $(this).data('id');
                addUrl = '{{ route('trparameter_doc.edit', ':id') }}'.replace(':id', id);
                $('#form_content').html(
                    '<center><img src="{{ pkg_asset('tazamcore', 'assets/img/loading.gif') }}" class="img-responsive"></center>'
                ).load(addUrl);

            })
        });
    </script>



@endsection
