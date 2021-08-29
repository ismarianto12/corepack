<section class="section">
    <div class="row">
        <div class="col-12">
            <h4 class="section-title">{{ _('Overide Data Ismarianto ' . $no_aplikasi) }}</h4>
            <div class="p-5 bg-white rounded">
                <!-- Rounded tabs -->
                <ul id="myTab" role="tablist"
                    class="nav nav-tabs nav-pills flex-column flex-sm-row text-center bg-light border-0 rounded-nav">
                    <li class="nav-item flex-sm-fill">
                        <a id="nasabah-tab" data-toggle="tab" href="#nasabah" role="tab" aria-controls="nasabah"
                            aria-selected="true"
                            class="nav-link border-0 text-uppercase font-weight-bold active">Penerima Manfaat</a>
                    </li>

                    <li class="nav-item flex-sm-fill">
                        <a id="parameter-tab" data-toggle="tab" href="#parameter" role="tab" aria-controls="parameter"
                            aria-selected="false" class="nav-link border-0 text-uppercase font-weight-bold">
                            Data Penerima Manfaat</a>
                    </li>
                </ul>
                <div id="ket"></div>

                <div id="myTabContent" class="tab-content">
                    <div id="nasabah" role="tabpanel" aria-labelledby="nasabah-tab"
                        class="tab-pane fade px-4 py-5 show active">
                        <h4>Keterangan overide </h4>

                        {{-- @dd($keterangan_overide_peserta); --}}
                        @foreach ($keterangan_overide_peserta as $datas => $val)
                            <p> {{ $val }} </p>
                        @endforeach
                        <hr />
                        <h3 class="section-title"><i class="fas fa fa-user-circle"></i> Personal (Pribadi)
                        </h3>
                        <div class="form-group row">
                            <input type="hidden" name="no_aplikasi" value="{{ $no_aplikasi }}">

                            <label for="name" class="col-md-2 text-left">No Ismarianto</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="no_aplikasi .."
                                    value="{{ $no_aplikasi }}" readonly>
                            </div>
                            <label for="name" class="col-md-2 text-left">Pilihan Program</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="no_aplikasi .."
                                    value="{{ $nama_program }}" readonly>
                                <br /><a href="#" onclick="javascript:detailparameter('{{ $tmparameter_id }}')"
                                    class="btn btn-primary">Detail data progam</a>
                                <br />
                                <small>Untuk melihat rincian program yang diambil silahkan klik</small>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Jenis Hadiah </label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="jenis hadiah"
                                    value="{{ $jenis_hadiah }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Nomor KTP / NIK</label>
                            <div class="col-md-4">
                                <input type="number" name="no_ktp" class="form-control" placeholder="no_ktp .."
                                    value="{{ $no_ktp }}" disabled>
                            </div>
                            <label for="name" class="col-md-2 text-left">Nama Ibu Kandung KTP</label>
                            <div class="col-md-4">
                                <input type="text" name="nama_ibu_kandung_ktp" class="form-control"
                                    placeholder="nama_ibu_kandung_ktp .." value="{{ $nama_ibu_kandung_ktp }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="name" class="col-md-2 text-left">Nama Sesuai KTP</label>
                            <div class="col-md-4">
                                <input type="text" name="nama_sesuai_ktp" class="form-control"
                                    placeholder="nama_sesuai_ktp .." value="{{ $nama_sesuai_ktp }}" disabled>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Tempat Lahir</label>
                            <div class="col-md-4">
                                <input type="text" name="tempat_lahir_ktp" class="form-control"
                                    placeholder="tempat_lahir_ktp .." value="{{ $tempat_lahir_ktp }}" disabled>
                            </div>
                            <label for="name" class="col-md-2 text-left">Tanggal Lahir KTP</label>
                            <div class="col-md-4">
                                <input type="text" name="tanggal_lahir_ktp" class="form-control"
                                    placeholder="tanggal_lahir_ktp .." value="{{ $tanggal_lahir_ktp }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Usia Peserta</label>
                            <div class="col-md-4">
                                <input type="text" name="umur_peserta" class="form-control"
                                    placeholder="umur_peserta .." value="{{ $umur_peserta }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Jenis Kelamin</label>
                            <div class="col-md-4">
                                {{ $jenis_kelamin_ktp == 'L' ? 'Laki laki' : 'Perempuan' }}
                            </div>
                            <label for="name" class="col-md-2 text-left">Pekerjaan KTP</label>
                            <div class="col-md-4">
                                <input type="text" name="pekerjaan_ktp" class="form-control"
                                    placeholder="pekerjaan_ktp .." value="{{ $pekerjaan_ktp }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Status pernikahan</label>
                            <div class="col-md-4">
                                <input type="text" name="status_pernikahan_ktp" class="form-control"
                                    placeholder="status_pernikahan_ktp .." value="{{ $status_pernikahan_ktp }}"
                                    disabled>
                            </div>
                            <label for="name" class="col-md-2 text-left">Alamat Sesuai KTP</label>
                            <div class="col-md-4">
                                <input type="text" name="alamat_sesuai_ktp" class="form-control"
                                    placeholder="alamat_sesuai_ktp .." value="{{ $alamat_sesuai_ktp }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Agama</label>
                            <div class="col-md-4">
                                <select class="form-control select2" name="agama" disabled>
                                    @foreach (Tmparamtertr::get_religion() as $key => $keys)
                                        @php
                                            $selected = $key == $agama ? 'selected' : '';
                                        @endphp
                                        <option value="{{ $key }}" {{ $selected }}>
                                            {{ $keys }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="name" class="col-md-2 text-left">No Handphone</label>
                            <div class="col-md-4">
                                <input type="text" name="no_hp" class="form-control" placeholder="No Handphone .."
                                    value="{{ $no_hp }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Email</label>
                            <div class="col-md-4">
                                <input type="email" name="email" class="form-control" placeholder="Email .."
                                    value="{{ $email }}" disabled>
                            </div>
                            <label for="name" class="col-md-2 text-left">Telephone</label>
                            <div class="col-md-4">
                                <input type="number" name="tlp_rumah" class="form-control" placeholder="Telephone .."
                                    value="{{ $tlp_rumah }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Penghasilan Perbulan</label>
                            <div class="col-md-4">
                                <input type="text" name="penghasilan_perbulan"
                                    class="Tmparamtertr::curency form-control" placeholder="penghasilan_perbulan .."
                                    value="{{ Tmparamtertr::curency($penghasilan_perbulan) }}" disabled>
                            </div>
                            <label for="name" class="col-md-2 text-left">Penghasilan Pertahun </label>
                            <div class="col-md-4">
                                <input type="text" name="penghasilan_pertahun"
                                    class="Tmparamtertr::curency form-control" placeholder="penghasilan_pertahun .."
                                    value="{{ Tmparamtertr::curency($penghasilan_pertahun) }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Pengeluaran Pertahun</label>
                            <div class="col-md-4">
                                <input type="text" name="pengeluaran_pertahun"
                                    class="Tmparamtertr::curency form-control" placeholder="Pengeluarn Pertahun .."
                                    value="{{ Tmparamtertr::curency($pengeluaran_pertahun) }}" disabled>
                            </div>
                            <label for="name" class="col-md-2 text-left">Status tempat tinggal</label>
                            <div class="col-md-4">
                                <select class="form-control" name="status_tempat_tinggal" disabled>
                                    @foreach (Tmparamtertr::tempattinggal() as $val => $tempattinggal)
                                        <option value="{{ $val }}">{{ $tempattinggal }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label for="name" class="col-md-2 text-left">Jumlah Tanggungan</label>
                            <div class="col-md-4">
                                <input type="text" name="jumlah_tanggungan" class="form-control"
                                    placeholder="Jumlah Tanggungan .." value="{{ $jumlah_tanggungan }}" disabled>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Tujuan Penggunaan Dana</label>
                            <div class="col-md-4">
                                <textarea name="tujuan_penggunaan" class="form-control" cols="4" rows="10" disabled>
                            {{ $tujuan_penggunaan }}
                                    </textarea>
                            </div>
                            <label for="name" class="col-md-2 text-left">Nama Kelurahan</label>
                            <div class="col-md-4">
                                <input type="text" name="kelurahan_ktp" class="form-control"
                                    placeholder="Nama Kelurahan .." value="{{ $kelurahan_ktp }}" disabled>
                            </div>
                        </div>


                        <hr />
                        <h3 class="section-title">Data Tempat Tinggal
                        </h3>
                        <div class="form-group row">

                            <label for="name" class="col-md-2 text-left">RT / RW</label>
                            <div class="col-md-4">
                                <input type="text" name="rt_rw_ktp" class="form-control" placeholder="rt_rw_ktp .."
                                    value="{{ $rt_rw_ktp }}" disabled>
                            </div>
                            <label for="name" class="col-md-2 text-left">Kelurahan Berdasarkan KTP</label>
                            <div class="col-md-4">
                                <input type="text" name="kelurahan_ktp" class="form-control"
                                    placeholder="kelurahan_ktp .." value="{{ $kelurahan_ktp }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Kecamatan</label>
                            <div class="col-md-4">
                                <input type="text" name="kecamatan_ktp" class="form-control"
                                    placeholder="kecamatan_ktp .." value="{{ $kecamatan_ktp }}" disabled>
                            </div>
                            <label for="name" class="col-md-2 text-left">Kota / Kabupaten </label>
                            <div class="col-md-4">
                                <input type="text" name="kota_kabupaten_ktp" class="form-control"
                                    placeholder="kota_kabupaten_ktp .." value="{{ $kota_kabupaten_ktp }}" disabled>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Provinsi</label>
                            <div class="col-md-4">
                                <input type="text" name="provinsi_ktp" class="form-control"
                                    placeholder="provinsi_ktp .." value="{{ $provinsi_ktp }}" disabled>
                            </div>
                            <label for="name" class="col-md-2 text-left">Kode POS</label>
                            <div class="col-md-4">
                                <input type="text" name="kode_pos_ktp" class="form-control"
                                    placeholder="kode_pos_ktp .." value="{{ $kode_pos_ktp }}" disabled>
                            </div>
                        </div>

                        <hr />
                        <h3 class="section-title">Data domisili</h3>
                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Alamat domisili</label>
                            <div class="col-md-4">
                                <input type="text" name="alamat_domisili" class="form-control"
                                    placeholder="alamat_domisili .." value="{{ $alamat_domisili }}" disabled>
                            </div>
                            <label for="name" class="col-md-2 text-left">RT / RW Domisili</label>
                            <div class="col-md-4">
                                <input type="text" name="rt_rw_domisili" class="form-control"
                                    placeholder="rt_rw_domisili .." value="{{ $rt_rw_domisili }}" disabled>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Kelurahan Domisili</label>
                            <div class="col-md-4">
                                <input type="text" name="kelurahan_domisili" class="form-control"
                                    placeholder="kelurahan_domisili .." value="{{ $kelurahan_domisili }}" disabled>
                            </div>
                            <label for="name" class="col-md-2 text-left">Kecamatan Domisili</label>
                            <div class="col-md-4">
                                <input type="text" name="kecamatan_domisili" class="form-control"
                                    placeholder="kecamatan_domisili .." value="{{ $kecamatan_domisili }}" disabled>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Kota Kabupaten Domisli</label>
                            <div class="col-md-4">
                                <input type="text" name="kota_kabupaten_domisili" class="form-control"
                                    placeholder="kota_kabupaten_domisili .." value="{{ $kota_kabupaten_domisili }}"
                                    disabled>
                            </div>
                            <label for="name" class="col-md-2 text-left">Provinsi Domisli</label>
                            <div class="col-md-4">
                                <input type="text" name="provinsi_domisili" class="form-control"
                                    placeholder="provinsi_domisili .." value="{{ $provinsi_domisili }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">

                            <label for="name" class="col-md-2 text-left">Kode Pos Domisili</label>
                            <div class="col-md-4">
                                <input type="text" name="kode_pos_domisili" class="form-control"
                                    placeholder="kode_pos_domisili .." value="{{ $kode_pos_domisili }}" disabled>
                            </div>
                            <label for="name" class="col-md-2 text-left">Jenis Penduduk</label>
                            <div class="col-md-4">
                                <input type="text" name="jenis_penduduk" class="form-control"
                                    placeholder="jenis_penduduk .." value="{{ $jenis_penduduk }}" disabled>
                            </div>
                        </div>

                        <hr />
                        <h3 class="section-title">Data Kewarganegaraan</h3>
                        <div class="form-group row">
                            <label for="name" class="col-md-2 text-left">Kewarganegaraan</label>
                            <div class="col-md-4">
                                @php
                                    $kwn = [
                                        'WNI' => 'Warga negara Indonesia',
                                        'WNA' => 'Warga negara Asing',
                                    ];
                                @endphp
                                <select class="form-control" name="kewarganegaraan" disabled>
                                    @foreach ($kwn as $kwns => $vals)
                                        @php
                                            $selected = $kwns == $kewarganegaraan ? 'selected' : '';
                                        @endphp
                                        <option value="{{ $kwns }}" {{ $selected }}>
                                            {{ $vals }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    {{-- @dd(count($overidemanfaat)) --}}
                    <div id="parameter" role="tabpanel" aria-labelledby="parameter-tab" class="tab-pane fade px-4 py-5">

                        @php
                            $j = 1;
                        @endphp

                        @if (count($overidemanfaat) <= 0)
                            <div class="alert alert-info"><i class="fas fa-check"></i>Data Penerima manfaat sudah
                                sesuai
                                dengan parameter
                                program </div>

                        @endif

                        {{-- @dd($pmanfaat_data) --}}
                        @foreach ($overidemanfaat as $kes => $manfaatdata)

                            <h2 class="section-title"><i class="fas fa-user"></i> Manfaat Ke -
                                {{ $j }}
                            </h2>
                            <div class="row">
                                <div class="col-12">
                                    <tt>Keterangan overide : </tt>
                                    <hr />
                                    @php
                                        $keoveride = $manfaatdata['keterangan_overide']['val'];
                                        if ($keoveride) {
                                            $f = str_replace(['["', '"]'], ['<p>', '</p>'], $keoveride);
                                        } else {
                                            $f = '';
                                        }
                                    @endphp
                                    {!! $f !!}
                                    <hr />
                                    <div class="form-group row">
                                        <input type="hidden" name="idnya_{{ $manfaatdata['id']['val'] }}"
                                            value="{{ $manfaatdata['id']['val'] }}">
                                        <label for="kode" class="col-md-2 text-left">Nomor Aplikasi</label>
                                        <div class="col-md-4"> {{ $manfaatdata['no_aplikasi']['val'] }}
                                        </div>
                                        <label for="kode" class="col-md-2 text-left">Nama</label>

                                        <div class="col-md-4">
                                            {{ $manfaatdata['nama']['val'] }}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="kode" class="col-md-2 text-left">Usia Penerima
                                            Manfaat</label>
                                        <div class="col-md-4">
                                            {{ $manfaatdata['usia']['val'] }}
                                        </div>
                                        <label for="kode" class="col-md-2 text-left">Hubungan</label>
                                        <div class="col-md-4">
                                            <select name="tmhubungan_id" class="form-control select2" disabled>


                                                {{-- @dd($manfaatdata); --}}

                                                @foreach ($hubungan as $hubungans)
                                                    @php
                                                        $selected = $manfaatdata['hubungan']['val'] == $hubungans->id ? 'selected' : '';
                                                    @endphp
                                                    <option value="{{ $hubungans->id }}" {{ $selected }}>
                                                        {{ $hubungans->nama_hubungan }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="kode" class="col-md-2 text-left">Pilihan Hadiah</label>

                                        <div class="col-md-4">
                                            {{ $manfaatdata['pilihan_hadiah']['val'] }}
                                        </div>
                                        <label for="kode" class="col-md-2 text-left">Nomor HP</label>

                                        <div class="col-md-4">
                                            {{ $manfaatdata['no_hp']['val'] }}
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label for="kode" class="col-md-2 text-left">Email</label>

                                        <div class="col-md-4">
                                            {{ $manfaatdata['email']['val'] }}
                                        </div>

                                        <label for="kode" class="col-md-2 text-left">Alamat</label>
                                        <div class="col-md-4">
                                            {{ $manfaatdata['alamat']['val'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label for="usia" class="col-md-2 text=left">Umur Penerima
                                    Manfaat</label>
                                <div class="col-md-4">
                                    {{ $manfaatdata['usia']['val'] }}
                                </div>

                            </div>


                            @if ($manfaatdata['catatan_pusat']['val'] != '')
                                <div class="alert alert-info">
                                    Catatan dari manager Business developmnet :<br />
                                    {{ $pusatusername }}
                                    {{ $manfaatdata['catatan_pusat']['val'] }}
                                </div>
                            @endif
                            @if ($manfaatdata['catatan_cabang']['val'] != '')

                                <div class="alert alert-info">
                                    Catatan dari manager operation : <br />
                                    {{ $cabangusername }}
                                    {{ $manfaatdata['catatan_cabang']['val'] }}
                            @endif
                    </div>



                    @php
                        $j++;
                    @endphp
                    @endforeach



                </div>

            </div>
            <!-- End rounded tabs -->
        </div>

    </div>
    </div>
</section>



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
        $('#simpan').on('submit', function(e) {
            e.preventDefault();
            if ($(this)[0].checkValidity() === false) {
                e.preventDefault();
                e.stopPropagation();
            } else {
                $.ajax({
                    url: "{{ route('overide.savedata') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    chace: false,
                    async: false,
                    success: function(data) {
                        $('#datatable').DataTable().ajax.reload();
                        $('#formmodal').modal('hide');
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Data berhasil di overide',
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

    function detailparameter(id) {
        event.preventDefault();
        $.dialog({
            title: false,
            content: 'url:{{ route('parameter.show', ':id') }}'.replace(':id', id),
            animation: 'scale',
            columnClass: 'large',
            closeAnimation: 'scale',
            boxWidth: '100%',
            boxHeight: '100%',
            useBootstrap: false,
            backgroundDismiss: true,
        });
    }
    // overide data 
</script>
