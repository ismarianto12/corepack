@extends('tazamcore::layouts.template')

@section('content')


    @include('tazamcore::tmparameter.css')
    <section class="section">
        <div class="card">
            <div class="col-12">

                <div class="container">
                    <div class="card-header">
                        <h4 class="section-title">{{ _('Upload Document  jaminan data peserta ') }}</h4>
                    </div>
                    {!! Tmparamtertr::get_detailnasabah($no_aplikasi) !!}
                    <br />
                    <hr />
                    @include('tazamcore::datajaminan.form_kelengkapan_part')
                </div>
            </div>
        </div>
    </section>
    <!-- End rounded tabs -->
    <script>
        $(function() {
            $("#simpan").on("submit", function(e) {
                e.preventDefault();

                $('#btnsimpan').removeClass('btn btn-primary');
                $('#btnsimpan').addClass('btn disabled btn-progress');

                if ($(this)[0].checkValidity() === false) {
                    $('#btnsimpan').removeClass('btn disabled btn-progress');
                    $('#btnsimpan').addClass('btn btn-primary');
                } else {
                    //  
                    var datastring = $(this).serialize();
                    $.ajax({
                        url: "{{ route('dokumenjaminan.uploaddata', $no_aplikasi) }}",
                        method: "POST",
                        data: datastring,
                        cache: false,
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 1) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: data.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                window.location.href =
                                    '{{ route('dokumenjaminan.index') }}';
                            }
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
