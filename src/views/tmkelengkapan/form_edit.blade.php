@extends('ismarianto::layouts.template')

@section('content')

    @include('ismarianto::tmparameter.css')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-user"></i> {{ _('Kelengkapan data document') }}</h4>
                </div>
                <div class="card-body">
                    <section class="section">

                        {!! Tmparamtertr::get_detailnasabah($no_aplikasi) !!}
                        <br />
                        <br />
                        <ul id="myTab" role="tablist"
                            class="nav nav-tabs nav-pills flex-column flex-sm-row text-center bg-light border-0 rounded-nav">
                            <li class="nav-item flex-sm-fill">
                                <a id="uploaddocument-tab" data-toggle="tab" href="#uploaddocument" role="tab"
                                    aria-controls="uploaddocument" aria-selected="true"
                                    class="nav-link border-0 text-uppercase font-weight-bold active">Upload
                                    Document</a>
                            </li>
                            <li class="nav-item flex-sm-fill">
                                <a id="kelengkapan-tab" data-toggle="tab" href="#kelengkapan" role="tab"
                                    aria-controls="kelengkapan" aria-selected="false"
                                    class="nav-link border-0 text-uppercase font-weight-bold">Kelengkapan data
                                    Peserta</a>
                            </li>

                            <li class="nav-item flex-sm-fill">
                                <a id="kelengkapaan_pmanfaat-tab" data-toggle="tab" href="#kelengkapan_pmanfaat" role="tab"
                                    aria-controls="kelengkapan_pmanfaat" aria-selected="false"
                                    class="nav-link border-0 text-uppercase font-weight-bold">Kelengkapan data
                                    Penerima Manfaat</a>
                            </li>
                        </ul>

                        <form id="simpan" class="needs-validation" novalidate>
                            <div id="myTabContent" class="tab-content">
                                <div id="uploaddocument" role="tabpanel" aria-labelledby="uploaddocument-tab"
                                    class="tab-pane fade px-4 py-5 show active">
                                    @include('ismarianto::tmkelengkapan.form_kelengkapan_part')
                                </div>
                                <div id="kelengkapan" role="tabpanel" aria-labelledby="kelengkapan-tab"
                                    class="tab-pane fade px-4 py-5">
                                    @include('ismarianto::tmkelengkapan.detailnasabah')

                                </div>
                                <div id="kelengkapan_pmanfaat" role="kelengkapan_pmanfaat"
                                    aria-labelledby="kelengkapan_pmanfaat-tab" class="tab-pane fade px-4 py-5">
                                    @include('ismarianto::tmkelengkapan.detailnasabah_manfaat')

                                </div>
                                <div class="form-group">
                                    <button id="btnsimpan" class="btn btn-primary btn-lg" type="submit"><i
                                            class="fas fa-save"></i>Simpan
                                        Data</button>&nbsp;&nbsp;&nbsp;
                                    <button id="btnreset" class="btn btn-warning btn-lg" type="reset"><i
                                            class="fas fa-reset"></i>Reset</button>
                                </div>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
    <!-- End rounded tabs -->
    <script type="text/javascript">
        (function() {
            'use strict';
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });

        })();
        // action save data
        $(function() {
            $("#simpan").on("submit", function(e) {
                e.preventDefault();
                $('#loading').modal('show');

                $('#btnsimpan').removeClass('btn btn-primary');
                $('#btnsimpan').addClass('btn disabled btn-progress');

                if ($(this)[0].checkValidity() === false) {

                    $('#btnsimpan').removeClass('btn disabled btn-progress');
                    $('#btnsimpan').addClass('btn btn-primary');
                } else {
                    //  
                    var datastring = $(this).serialize();
                    $.ajax({
                        url: "{{ route('uploaddankelengkapan.update', $id) }}",
                        method: "PUT",
                        data: datastring,
                        cache: false,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 1) {
                                $.dialog('Proses Menyimpan data ....');
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Document kelengkapan data nasabah berhsil di lengkapi',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                window.location.href =
                                    '{{ route('uploaddankelengkapan.index') }}';
                            }
                            $('#loading').modal('hide');

                        },
                        error: function(data) {
                            Swal.fire({
                                position: 'center',
                                icon: 'danger',
                                title: 'data kesalaha' + data,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                    return false;
                }

            });
        });
    </script>

@endsection
