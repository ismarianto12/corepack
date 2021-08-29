@include('aplikasi::tmparameter.css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">


<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

<div class="row">
    <div class="col-12">

        <div class="container">
            <h4>{{ _('Kelengkapan data document') }}</h4>
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
                    <a id="kelengkapan-tab" data-toggle="tab" href="#kelengkapan" role="tab" aria-controls="kelengkapan"
                        aria-selected="false" class="nav-link border-0 text-uppercase font-weight-bold">Kelengkapan data
                        Peserta</a>
                </li>

                <li class="nav-item flex-sm-fill">
                    <a id="kelengkapan_pmanfaat-tab" data-toggle="tab" href="#kelengkapan_pmanfaat" role="tab"
                        aria-controls="kelengkapan_pmanfaat" aria-selected="false"
                        class="nav-link border-0 text-uppercase font-weight-bold">Kelengkapan data
                        Penerima Manfaat</a>
                </li>
            </ul>
            <section class="section">
                <form enctype="multipart/form-data" id="simpan" class="needs-validation" novalidate>
                    <div id="myTabContent" class="tab-content">
                        <div id="uploaddocument" role="tabpanel" aria-labelledby="uploaddocument-tab"
                            class="tab-pane fade px-4 py-5 show active">
                            @include('nasabah::tmkelengkapan.form_kelengkapan_part')
                        </div>
                        <div id="kelengkapan" role="tabpanel" aria-labelledby="kelengkapan-tab"
                            class="tab-pane fade px-4 py-5">
                            @include('nasabah::tmkelengkapan.detailnasabah')

                        </div>
                        <div id="kelengkapan_pmanfaat" role="kelengkapan_pmanfaat"
                            aria-labelledby="kelengkapan_pmanfaat-tab" class="tab-pane fade px-4 py-5">
                            @include('nasabah::tmkelengkapan.detailnasabah_manfaat')

                        </div>
                        <div class="form-group">
                            <button id="btnsimpan" class="btn btn-primary btn-lg" type="submit"><i class="fas fa-save
                         "></i>Simpan Data</button>&nbsp;&nbsp;&nbsp;
                            <button id="btnreset" class="btn btn-warning btn-lg" type="reset"><i class="fas fa-reset
                         "></i>Reset</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
    <!-- End rounded tabs -->
</div>

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

    nama_file = '';
    nama_parameter = '';
    status_file = '';
    no_aplikasi = '{{ $no_aplikasi }}';
    nama_penerima_manfaat = '';
    id_penerima_manfaat = '';
    $(function() {
        $('#file_upload_nasabah').html('<h3>Silahhkan pilih file yang akan di upload</h3>');

        $('.nasabah').hide();
        $('.penerima_manfaat').hide();
        $('#jenis_').on('change', function() {
            $("select option").prop("disabled", false);
            if ($(this).val() == 1) {
                $('.nasabah').show();
                $('.penerima_manfaat').hide();
            } else {
                $('.nasabah').hide();
                $('.penerima_manfaat').show();
            }
        });
        // 

        $('.dropzone').hide();
        $('#nama_file_peserta').on('change', function() {
            $('#nama_file_penerimamanfaat').val('');
            $("select option").prop("disabled", false)
            if ($(this).val() == '') {
                $('#nama_file_penerimamanfaat').hide();
                $('.dropzone').hide();
            } else {
                $('#nama_file_penerimamanfaat').show();
                table_upload_nasabah(no_aplikasi, 'nasabah');
                $('.dropzone').show();
            }
            nama_file = $(this).val();
            nama_parameter = 'file_upload_nasabah';
            status_file = 'nasabah';
        });

        $('.dropzone').hide();
        $('#nama_file_penerimamanfaat').on('change', function() {
            $('#nama_file_peserta').val('');
            if ($('#nama_penerimamanfaat').val() == '') {
                swal('danger', 'silahkan pilih pengerima manaat terlebih dahulu', 'danger');
            } else {
                $("select option").prop("disabled", false);
                $('#nama_file_peserta').val('');

                if ($(this).val() == '') {
                    $('.dropzone').hide();
                } else {
                    tbpenerima_manfaat(no_aplikasi, 'penerimamanfaat');
                    $('.dropzone').show();
                }
            }
            nama_file = $(this).val();
            nama_parameter = 'file_upload_penerimamanfaat';
            status_file = 'penerimamanfaat';
            nama_penerima_manfaat = $('#nama_penerimamanfaat option:selected').text();
            id_penerima_manfaat = $('#nama_penerimamanfaat option:selected').val();

        });


        var nasabah = new Dropzone('#file_upload', {
            url: "{{ route('uploaddankelengkapan.lengkapi', $id) }}",
            parallelUploads: 18, //maksimal jumlah upload
            addRemoveLinks: true,
            maxFilesize: 10,
            maxFiles: 18,
            acceptedFiles: 'image/jpeg,image/png,image/jpg/pdf/word',
            params: {
                ref: "ref",
            },
            init: function() {
                thisDropzone = this;

                this.on("sending", function(file, xhr, formData) {
                    alert(nama_penerima_manfaat);

                    formData.append('nama_file', nama_file);
                    formData.append('no_aplikasi', '{{ $no_aplikasi }}');
                    formData.append('status', status_file);
                    formData.append('parameter', nama_parameter);
                    formData.append('tmparameter_id', '{{ $tmparameter_id }}');
                    formData.append('tmparameter_doc_id', nama_file);
                    formData.append('nama_penerima_manfaat', nama_penerima_manfaat);
                    formData.append('id_penerima_manfaat', id_penerima_manfaat);
                    console.log(formData)
                });

            },
            success: function(file, response) {
                $('.dropzone').hide();
                file.previewElement.remove();
                if (status_file == 'nasabah') {
                    table_upload_nasabah(no_aplikasi, status_file);
                } else if (status_file == 'penerimamanfaat') {
                    tbpenerima_manfaat(no_aplikasi, status_file);
                }
                Swal.fire(
                    'Info',
                    'File berhasil di upload',
                    'success'
                );

            },
            error: function(file, response) {
                file.previewElement.remove();
            },
            //Menghapus file dari database menggunakan ajax
            removedfile: function(file) {
                var name = file.name;
                var id = file.id;
                if (confirm("Are you sure want to delete?")) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('uploaddankelengkapan.delete_file') }}',
                        data: {
                            id: id,
                            name: name
                        },
                        sucess: function(data) {
                            console.log('success: ' + data);
                            // alert('Gambar telah di dihapus');
                            Swal.fire(
                                'Gambar',
                                'File berhasil di hapus',
                                'success'
                            );
                        }
                    });
                    var ref;
                    if ((ref = file.previewElement) != null) {
                        return ref.parentNode.removeChild(file.previewElement);

                    }
                    return false;
                }
            },
        });
    });

    $(function() {
        $("#simpan").on("submit", function(e) {
            e.preventDefault();

            $('#btnsimpan').removeClass('btn btn-primary');
            $('#btnsimpan').addClass('btn disabled btn-primary btn-progress');

            if ($(this)[0].checkValidity() === false) {

                $('#btnsimpan').removeClass('btn disabled btn-primary btn-progress');
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
                            $('#datatable').DataTable().ajax.reload();
                            // $('#formmodal').modal('hide');
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data berhasil di simpan',
                                showConfirmButton: false,
                                timer: 1500
                            });
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


    //  table_file_nasabah
    // table_file_penerima_manfaat


    function table_upload_nasabah(no_aplikasi, status) {

        $.post('{{ route('uploaddankelengkapan.table_file_nasabah') }}', {
            no_aplikasi: no_aplikasi,
            status: status,
        }, function(data) {
            $('#table_file_nasabah').html(data);
        });
    }

    function tbpenerima_manfaat(no_aplikasi, status) {
        $.post('{{ route('uploaddankelengkapan.table_file_penerima_manfaat') }}', {
            no_aplikasi: no_aplikasi,
            status: status,
        }, function(data) {
            $('#table_file_penerima_manfaat').html(data);
        });
    }
</script>
