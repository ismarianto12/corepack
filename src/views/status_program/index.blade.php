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

                <form class="form-horizontal" method="POST">

                    <div class="form-group row">
                        <label for="kode" class="col-md-2 text-center">Status Program</label>
                        <div class="col-md-4">

                            <select class="select2 form-control" name="status_program" id="status_program">
                                <option value="">Semua Status Program</option>
                                @foreach ($statusdata as $statusdatas)
                                    <option value="{{ $statusdatas->id }}">
                                        {{ $statusdatas->keterangan_status }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </form>

                <br />
                <div class="card-body p-0">
                    <div class="container">
                        <div id="status"></div>
                        <br />
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
        <div class="modal-dialog" role="document" style=" min-width: 90%;padding-left: 17px; overflow: auto;">
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


    <script src="https://project.ptlmp.my.id/assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>

    <script>
        // table data
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
                url: "{{ route('api.statusprogram') }}",
                method: 'POST',
                data: function(data) {
                    data.status_program = $('#status_program').val()

                },
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

        $('#status_program').on('change', function(data) {
            $('#datatable').DataTable().ajax.reload();

            ket = $(this).find('option:selected').text();
            $('#status').html('<div class="alert alert-success"><i class="fa fa-check"></i>Pencarian status ' +
                ket +
                '</div>');

        });
        @include('ismarianto::layouts.tablechecked');

        // addd
    </script>

@endsection
