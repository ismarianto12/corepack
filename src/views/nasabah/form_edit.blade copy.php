@extends('tazamcore::layouts.template')
@section('content')

    <div class="row">
        <div class="col-12">
            <section class="section">
                <div class="p-8 bg-white rounded">
                    <ul id="myTab" role="tablist"
                        class="nav nav-tabs nav-pills flex-column flex-sm-row text-center bg-light border-0 rounded-nav">
                        <li class="nav-item flex-sm-fill">
                            <a id="nasabah-tab" data-toggle="tab" href="#nasabah" role="tab" aria-controls="nasabah"
                                aria-selected="true" class="nav-link border-0 text-uppercase font-weight-bold active">Data
                                Ismarianto</a>
                        </li>
                        <li class="nav-item flex-sm-fill">
                            <a id="parameter-tab" data-toggle="tab" href="#parameter" role="tab" aria-controls="parameter"
                                aria-selected="false" class="nav-link border-0 text-uppercase font-weight-bold">
                                Data Penerima Manfaat</a>
                        </li>
                    </ul>


                    <div id="ket"></div>

                    <form id="simpan" class="needs-validation" novalidate="">
                        @csrf
                        <div id="myTabContent" class="tab-content">
                            <div id="nasabah" role="tabpanel" aria-labelledby="nasabah-tab"
                                class="tab-pane fade px-4 py-5 show active">

                                <hr />
                                <h3 class="section-title">Data Personal (Pribadi)
                                </h3>
                                <div class="form-group row">
                                    <input type="hidden" name="nasabah" value="nasabah">
                                    <label for="name" class="col-md-2 text-left">No Ismarianto</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" placeholder="no_aplikasi .."
                                            value="{{ $no_aplikasi }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Nomor KTP / NIK</label>
                                    <div class="col-md-4">
                                        <input type="number" name="no_ktp" class="form-control" placeholder="no_ktp .."
                                            value="{{ $no_ktp }}" required>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Nama Ibu Kandung KTP</label>
                                    <div class="col-md-4">
                                        <input type="text" name="nama_ibu_kandung_ktp" class="form-control"
                                            placeholder="nama_ibu_kandung_ktp .." value="{{ $nama_ibu_kandung_ktp }}"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="name" class="col-md-2 text-left">Nama Sesuai KTP</label>
                                    <div class="col-md-4">
                                        <input type="text" name="nama_sesuai_ktp" class="form-control"
                                            placeholder="nama_sesuai_ktp .." value="{{ $nama_sesuai_ktp }}" required>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Tempat Lahir</label>
                                    <div class="col-md-4">
                                        <input type="text" name="tempat_lahir_ktp" class="form-control"
                                            placeholder="tempat_lahir_ktp .." value="{{ $tempat_lahir_ktp }}" required>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Tanggal Lahir KTP</label>
                                    <div class="col-md-4">
                                        <input type="text" name="tanggal_lahir_ktp" class="form-control"
                                            placeholder="tanggal_lahir_ktp .." value="{{ $tanggal_lahir_ktp }}" required
                                            onchange="umur()">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Jenis Kelamin</label>
                                    <div class="col-md-4">
                                        <select class="form-control select2" name="jenis_kelamin">
                                            <option value="L">Laki laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Pekerjaan KTP</label>
                                    <div class="col-md-4">
                                        <input type="text" name="pekerjaan_ktp" class="form-control"
                                            placeholder="pekerjaan_ktp .." value="{{ $pekerjaan_ktp }}" required>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Status pernikahan</label>
                                    <div class="col-md-4">
                                        <input type="text" name="status_pernikahan_ktp" class="form-control"
                                            placeholder="status_pernikahan_ktp .." value="{{ $status_pernikahan_ktp }}"
                                            required>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Alamat Sesuai KTP</label>
                                    <div class="col-md-4">
                                        <input type="text" name="alamat_sesuai_ktp" class="form-control"
                                            placeholder="alamat_sesuai_ktp .." value="{{ $alamat_sesuai_ktp }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Agama</label>
                                    <div class="col-md-4">
                                        <select class="form-control select2" name="agama">
                                            @foreach (Tmparamtertr::get_religion() as $key => $keys)
                                                <option value="{{ $key }}"> {{ $keys }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">No Handphone</label>
                                    <div class="col-md-4">
                                        <input type="text" name="no_hp" class="form-control" placeholder="No Handphone .."
                                            value="{{ $no_hp }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Email</label>
                                    <div class="col-md-4">
                                        <input type="email" name="email" class="form-control" placeholder="Email .."
                                            value="{{ $email }}" required>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Telephone</label>
                                    <div class="col-md-4">
                                        <input type="number" name="tlp_rumah" class="form-control"
                                            placeholder="Telephone .." value="{{ $tlp_rumah }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Penghasilan Perbulan</label>
                                    <div class="col-md-4">
                                        <input type="text" name="penghasilan_perbulan" class="number_format form-control"
                                            placeholder="penghasilan_perbulan .." value="{{ $penghasilan_perbulan }}"
                                            required>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Penghasilan Pertahun </label>
                                    <div class="col-md-4">
                                        <input type="text" name="penghasilan_pertahun" class="number_format form-control"
                                            placeholder="penghasilan_pertahun .." value="{{ $penghasilan_pertahun }}"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Pengeluaran Pertahun</label>
                                    <div class="col-md-4">
                                        <input type="text" name="pengeluaran_pertahun" class="number_format form-control"
                                            placeholder="Pengeluarn Pertahun .." value="{{ $pengeluaran_pertahun }}"
                                            required>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Status tempat tinggal</label>
                                    <div class="col-md-4">
                                        <input type="text" name="status_tempat_tinggal" class="form-control"
                                            placeholder="Status Tempat Tinggal .." value="{{ $status_tempat_tinggal }}"
                                            required>
                                    </div>
                                </div>


                                <div class="form-group row">

                                    <label for="name" class="col-md-2 text-left">Jumlah Tanggungan</label>
                                    <div class="col-md-4">
                                        <input type="text" name="jumlah_tanggungan" class="form-control"
                                            placeholder="Jumlah Tanggungan .." value="{{ $jumlah_tanggungan }}" required>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Tujuan Penggunaan Dana</label>
                                    <div class="col-md-4">
                                        <textarea name="tujuan_penggunaan" class="form-control" cols="4" rows="10">
                                                                                                                                                                                                                                                                                                                                                                                                                    {{ $tujuan_penggunaan }}
                                                                                                                                                                                                                                                                                                                                                                                                                            </textarea>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Nama Kelurahan</label>
                                    <div class="col-md-4">
                                        <input type="text" name="nama_kelurahan" class="form-control"
                                            placeholder="Nama Kelurahan .." value="{{ $nama_kelurahan }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="name" class="col-md-2 text-left">Umur Peserta</label>
                                    <div class="col-md-4">
                                        <input type="number" name="umur_peserta" class="form-control"
                                            placeholder="umur_peserta .." value="{{ $umur_peserta }}" required readonly>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Status Peserta </label>
                                    <div class="col-md-4">
                                        <input type="text" name="status_peserta" class="form-control"
                                            placeholder="status_peserta .." value="{{ $status_peserta }}" required>
                                    </div>
                                </div>

                                <hr />
                                <h3 class="section-title">Data Tempat Tinggal
                                </h3>
                                <div class="form-group row">

                                    <label for="name" class="col-md-2 text-left">Rt / RW</label>
                                    <div class="col-md-4">
                                        <input type="text" name="rt_rw_ktp" class="form-control" placeholder="rt_rw_ktp .."
                                            value="{{ $rt_rw_ktp }}" required>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Kelurahan Berdasarkan KTP</label>
                                    <div class="col-md-4">
                                        <input type="text" name="kelurahan_ktp" class="form-control"
                                            placeholder="kelurahan_ktp .." value="{{ $kelurahan_ktp }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Kecamatan</label>
                                    <div class="col-md-4">
                                        <input type="text" name="kecamatan_ktp" class="form-control"
                                            placeholder="kecamatan_ktp .." value="{{ $kecamatan_ktp }}" required>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Kota / Kabupaten </label>
                                    <div class="col-md-4">
                                        <input type="text" name="kota_kabupaten_ktp" class="form-control"
                                            placeholder="kota_kabupaten_ktp .." value="{{ $kota_kabupaten_ktp }}"
                                            required>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Provinsi</label>
                                    <div class="col-md-4">
                                        <input type="text" name="provinsi_ktp" class="form-control"
                                            placeholder="provinsi_ktp .." value="{{ $provinsi_ktp }}" required>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Kode POS</label>
                                    <div class="col-md-4">
                                        <input type="text" name="kode_pos_ktp" class="form-control"
                                            placeholder="kode_pos_ktp .." value="{{ $kode_pos_ktp }}" required>
                                    </div>
                                </div>

                                <hr />
                                <h3 class="section-title">Data domisili</h3>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Alamat domisili</label>
                                    <div class="col-md-4">
                                        <input type="text" name="alamat_domisili" class="form-control"
                                            placeholder="alamat_domisili .." value="{{ $alamat_domisili }}" required>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">RT / rw Domisili</label>
                                    <div class="col-md-4">
                                        <input type="text" name="rt_rw_domisili" class="form-control"
                                            placeholder="rt_rw_domisili .." value="{{ $rt_rw_domisili }}" required>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Kelurahan Domisili</label>
                                    <div class="col-md-4">
                                        <input type="text" name="kelurahan_domisili" class="form-control"
                                            placeholder="kelurahan_domisili .." value="{{ $kelurahan_domisili }}"
                                            required>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Kecamatan Domisili</label>
                                    <div class="col-md-4">
                                        <input type="text" name="kecamatan_domisili" class="form-control"
                                            placeholder="kecamatan_domisili .." value="{{ $kecamatan_domisili }}"
                                            required>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Kota Kabupaten Domisli</label>
                                    <div class="col-md-4">
                                        <input type="text" name="kota_kabupaten_domisili" class="form-control"
                                            placeholder="kota_kabupaten_domisili .."
                                            value="{{ $kota_kabupaten_domisili }}" required>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Provinsi Domisli</label>
                                    <div class="col-md-4">
                                        <input type="text" name="provinsi_domisili" class="form-control"
                                            placeholder="provinsi_domisili .." value="{{ $provinsi_domisili }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label for="name" class="col-md-2 text-left">Kode Pos Domisili</label>
                                    <div class="col-md-4">
                                        <input type="text" name="kode_pos_domisili" class="form-control"
                                            placeholder="kode_pos_domisili .." value="{{ $kode_pos_domisili }}" required>
                                    </div>
                                    <label for="name" class="col-md-2 text-left">Jenis Penduduk</label>
                                    <div class="col-md-4">
                                        <input type="text" name="jenis_penduduk" class="form-control"
                                            placeholder="jenis_penduduk .." value="{{ $jenis_penduduk }}" required>
                                    </div>
                                </div>

                                <hr />
                                <h3 class="section-title">Data Kewarganegaraan</h3>


                                <div class="form-group row">
                                    <label for="name" class="col-md-2 text-left">Kewarganegaraan</label>
                                    <div class="col-md-4">
                                        <select class="form-control" name="kewarganegaraan">
                                            <option value="WNI">Warga Negara Indonesia (WNI)</option>
                                            <option value="WNI">Warga Negara Asing (WNA)</option>
                                        </select>
                                    </div>
                                </div>



                            </div>

                            <div id="parameter" role="tabpanel" aria-labelledby="parameter-tab"
                                class="tab-pane fade px-4 py-5">
                                {{-- parameter --}}
                                <div class="form-group row">

                                    <label for="tujuan_penggunaan" class="col-md-2 text=left">PROGRAM TAZAM</label>
                                    <div class="col-md-4">
                                        <select class="form-control" name="tmparameter_id">
                                            @foreach ($program as $programs)
                                                <option value="{{ $programs->id }}">{{ $programs->kode_prog }} -
                                                    {{ $programs->nama_prog }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <label for="pilihan_hadiah" class="col-md-2 text=left">Pilihan Hadiah
                                    </label>
                                    <div class="col-md-4">

                                        <select class="form-control" name="hadiah">
                                            @foreach ($hadiah as $hadiah)
                                                <option value="{{ $hadiah->id }}">{{ $hadiah->jenis_hadiah }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please Entry Pilihan Hadiah
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tujuan_penggunaan" class="col-md-2 text=left">Tujuan Penggunaan</label>
                                    <div class="col-md-4">
                                        <textarea class="form-control" name="tujuan_penggunaan"
                                            id="tujuan_penggunaan"></textarea>
                                    </div>
                                    <label for="jum_penerima_manfaat" class="col-md-2 text=left">Jumlah Penerima
                                        manfaat</label>
                                    <div class="col-md-4">
                                        <select class="form-control" name="jumlah_penerima_manfaat"
                                            id="jumlah_penerima_manfaat">
                                            <option value="">Pilih Penerima Manfaat</option>
                                            @for ($a = 1; $a <= 8; $a++)
                                                @php
                                                    $selected = $a == $jumlah_penerima_manfaat ? 'selected' : '';
                                                @endphp
                                                <option value="{{ $a }}" {{ $selected }} disabled>
                                                    {{ $a }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="jumlah_nya"></div>
                            </div>
                            <div id="phadiah" role="tabpanel" aria-labelledby="phadiah-tab" class="tab-pane fade px-4 py-5">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary btn-lg mr-1" type="submit"><i
                                    class="fa fa-save"></i>Simpan</button>
                            <button class="btn btn-danger btn-lg" type="reset" data-dismiss="modal"><i
                                    class="fa fa-reload"></i>Reset</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
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

        $(function() {

            $.ajax({
                url: "{{ route('nasabah.penerima_manfaat_edit') }}",
                method: "POST",
                data: 'jumlah_penerima_manfaat={{ $jumlah_penerima_manfaat }}&no_aplikasi={{ $no_aplikasi }}',
                chace: false,
                async: false,
                success: function(data) {
                    $('.jumlah_nya').html(data);
                },
                error: function(data, JqxHR, Error) {
                    Swal.fire('Error Reques :' + Error);
                }
            });

            // get data jumlah nya berapa  
            $('#jumlah_penerima_manfaat').on('change', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('nasabah.penerima_manfaat_edit') }}",
                    method: "POST",
                    data: 'jumlah_penerima_manfaat=' + $(this).val(),
                    chace: false,
                    async: false,
                    success: function(data) {
                        $('.jumlah_nya').html(data);
                    },
                    error: function(data, JqxHR, Error) {
                        Swal.fire('Error Reques :' + Error);
                    }
                });

            });
            $('#simpan').on('submit', function(e) {
                e.preventDefault();
                if ($(this)[0].checkValidity() === false) {
                    e.preventDefault();
                    e.stopPropagation();
                } else {
                    $.ajax({
                        url: "{{ route('nasabah.update', $id) }}",
                        method: "PUT",
                        data: $(this).serialize(),
                        chace: false,
                        async: false,
                        success: function(data) {
                            window.location.href = '{{ route('nasabah.index') }}';
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Data berhasil di simpan',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        },
                        error: function(data) {
                            var div = $('#container');
                            setInterval(function() {
                                var pos = div.scrollTop();
                                div.scrollTop(pos + 2);
                            }, 10)
                            err = '';
                            respon = data.responseJSON;
                            $.each(respon.errors, function(index, value) {
                                err += "<li>" + value + "</li>";
                            });
                            $('.ket').html(
                                "<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Perahtian donk!</strong> " +
                                respon.message + "<ol class='pl-3 m-0'>" + err +
                                "</ol></div>");

                        }
                    })
                }
            });
        });
        // overide data 
    </script>

@endsection
