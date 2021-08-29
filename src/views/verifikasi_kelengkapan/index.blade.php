@extends('tazamcore::layouts.template')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Document Jaminan Belum Upload</h4>
                            </div>
                            <div class="card-body" id="jaminanbelumupload">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Otirisasi dan pembukaan rekening</h4>
                            </div>
                            <div class="card-body" id="otorisasirek">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah nasabah yang berhasil di lengkapi</h4>
                            </div>
                            <div class="card-body" id="lengkap">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
        <div class="modal-dialog" role="document" style=" min-width: 100%;padding-left: 17px;overflow: auto;">
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
        $(function() {

            $.get('{{ route('notif.jaminanbelumupload') }}', function(data) {
                $('#jaminanbelumupload').html(data);
            });
            $.get('{{ route('notif.otorisasirek') }}', function(data) {
                $('#otorisasirek').html(data);
            });
            $.get('{{ route('notif.lengkap') }}', function(data) {
                $('#lengkap').html(data);
            });
        })


        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            order: [1, 'asc'],
            pageLength: 10,
            ajax: {
                url: "{{ route('api.dokumenjaminanverify') }}",
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
        @include('tazamcore::layouts.tablechecked');
        // addd
        $(function() {
            $('#datatable').on('click', '#lengkapi', function(e) {
                e.preventDefault();
                $('#formmodal').modal('show', {
                    backdrop: 'static',
                    keyboard: false
                });
                id = $(this).data('id');
                addUrl = '{{ route('verifikasikelengkapan.edit', ':id') }}'.replace(':id', id);
                $('#form_content').html(
                    '<center><img src="{{ pkg_asset('tazamcore', 'assets/img/loading.gif') }}" class="img-responsive"></center>'
                ).load(addUrl);

            })
        });
    </script>

@endsection

{{-- {{ pkg_asset('tazamcore', 'assets/img/loading.gif') }} --}}
