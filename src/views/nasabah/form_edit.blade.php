@extends('tazamcore::layouts.template')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-action">
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12">
                            <section class="section">
                                <div class="p-5 bg-white rounded">
                                    <!-- Rounded tabs -->
                                    <ul id="myTab" role="tablist"
                                        class="nav nav-tabs nav-pills flex-column flex-sm-row text-center bg-light border-0 rounded-nav">
                                        <li class="nav-item flex-sm-fill">
                                            <a id="nasabah-tab" data-toggle="tab" href="#nasabah" role="tab"
                                                aria-controls="nasabah" aria-selected="true"
                                                class="nav-link border-0 text-uppercase font-weight-bold active">Data
                                                Ismarianto</a>
                                        </li>
                                        <li class="nav-item flex-sm-fill">
                                            <a id="parameter-tab" data-toggle="tab" href="#parameter" role="tab"
                                                aria-controls="parameter" aria-selected="false"
                                                class="nav-link border-0 text-uppercase font-weight-bold">
                                                Data Penerima Manfaat</a>
                                        </li>
                                    </ul>

                                    <div class="ket"></div>

                                    <form id="simpan" class="needs-validation" novalidate="">
                                        @csrf
                                        <div id="myTabContent" class="tab-content">
                                            <div id="nasabah" role="tabpanel" aria-labelledby="nasabah-tab"
                                                class="tab-pane fade px-4 py-5 show active">
                                                {{-- masanah was here --}}
                                                @if ($overide_status != 0)
                                                    @if ($overide_status == 2)
                                                        <hr />
                                                        <div class="alert alert-danger">Catatan revisi OM :

                                                            {{ $catatan_revise_peserta }}
                                                            <br />
                                                            <h4>Catatan overide </h4>
                                                            @foreach (json_decode($keterangan_overide) as $datas => $val)
                                                                <p> {{ $val }} </p>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endif
                                                <hr />
                                                <h3 class="section-title">Pilihan Program
                                                </h3>
                                                <br />
                                                <div class="form-group row">
                                                    <input type="hidden" name="nasabah" value="nasabah">
                                                    <label for="name" class="col-md-2 text-left">No Ismarianto</label>

                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" placeholder="no_aplikasi .."
                                                            value="{{ $no_aplikasi }}" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="tujuan_penggunaan" class="col-md-2 text=left">Program
                                                        Tazam</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="tmparameter_id" required>
                                                            <option value="">
                                                                @foreach ($program as $programs)
                                                                    @php
                                                                        $selectedprg = $programs->id == $tmparameter_id ? 'selected' : '';
                                                                    @endphp

                                                            <option value="{{ $programs->id }}" {{ $selectedprg }}>
                                                                {{ $programs->kode_prog }} -
                                                                {{ $programs->nama_prog }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="detail_program"></div>
                                                    </div>

                                                    <label for="pilihan_hadiah" class="col-md-2 text=left">Pilihan
                                                        Hadiah
                                                    </label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="hadiah">
                                                            @foreach ($tmhadiah as $tmhadiahs)
                                                                @php
                                                                    $selectedhdd = $tmhadiah_id == $tmhadiahs->id ? 'selected' : '';
                                                                @endphp
                                                                <option value="{{ $tmhadiahs->id }}" {{ $selectedhdd }}>
                                                                    {{ $tmhadiahs->jenis_hadiah }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            Silahkan Entry Pilihan Hadiah
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                                <h3 class="section-title">Data Personal (Pribadi)
                                                </h3>
                                                <br />

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Nomor KTP / NIK</label>
                                                    <div class="col-md-4">
                                                        <input type="number" name="no_ktp" class="form-control"
                                                            placeholder="Silahkan Entry No KTP" value="{{ $no_ktp }}"
                                                            required>
                                                    </div>
                                                    <br />

                                                    <label for="name" class="col-md-2 text-left">Nama Ibu Kandung
                                                        KTP</label>
                                                    <br />
                                                    <div class="col-md-4">
                                                        <input type="text" name="nama_ibu_kandung_ktp" class="form-control"
                                                            value="{{ $nama_ibu_kandung_ktp }}"
                                                            placeholder="Silahkan Entry Nama Ibu Kandung" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Nama Sesuai KTP</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="nama_sesuai_ktp"
                                                            value="{{ $nama_sesuai_ktp }}" class="form-control"
                                                            placeholder="Silahkan Entry Nama" required>
                                                    </div>

                                                    <label for="name" class="col-md-2 text-left">Tanggal Lahir
                                                        KTP</label>
                                                    <div class="col-md-4">
                                                        <input type="date" value="{{ $tanggal_lahir_ktp }}"
                                                            name="tanggal_lahir_ktp" id="tanggal_lahir_ktp"
                                                            class="form-control" placeholder="Silahkan Entry Tanggal Lahir"
                                                            onchange="umur()" required>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Tempat Lahir</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="tempat_lahir_ktp"
                                                            value="{{ $tempat_lahir_ktp }}" class="form-control"
                                                            placeholder="Silahkan Entry Tempat Lahir" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Umur Peserta</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="umur_peserta"
                                                            class="number_format form-control"
                                                            placeholder="Umur Sesuai tanggal lahir otomatis"
                                                            id="umur_peserta" value="{{ $umur_peserta }}" readonly
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Jenis Kelamin</label>
                                                    <div class="col-md-4">

                                                        @php
                                                            $jk = [
                                                                'L' => 'Laki - Laki',
                                                                'P' => 'Perempuan',
                                                            ];
                                                        @endphp
                                                        <select class="form-control" name="jenis_kelamin_ktp">
                                                            @foreach ($jk as $jks => $key)
                                                                @php
                                                                    $jkselected = $jks == $jenis_kelamin_ktp ? 'selected' : '';
                                                                @endphp
                                                                <option value="{{ $jks }}" {{ $jkselected }}>
                                                                    {{ $key }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Pekerjaan KTP</label>
                                                    <div class="col-md-4">
                                                        <select name="pekerjaan_ktp" class="form-control select2">
                                                            <option>Pegawai Negeri / BUMN</option>
                                                            <option>Pegawai Swasta</option>
                                                            <option>Wiraswasta </option>
                                                            <option>Pelajar /Mahasiswa</option>
                                                            <option>Ibu Rumah Tangga</option>
                                                            <option>Lainya</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Agama</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control select2" name="agama">
                                                            @foreach (Tmparamtertr::get_religion() as $key => $keys)
                                                                <option value="{{ $key }}"> {{ $keys }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">No Handphone</label>
                                                    <div class="col-md-4">
                                                        <input type="number" name="no_hp" value="{{ $no_hp }}"
                                                            class="form-control" placeholder="Silahkan Entry No.Handphone"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Email</label>
                                                    <div class="col-md-4">
                                                        <input type="email" name="email" class="form-control"
                                                            value="{{ $email }}" placeholder="Silahkan Entry Email"
                                                            required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Telephone</label>
                                                    <div class="col-md-4">
                                                        <input type="number" value="{{ $tlp_rumah }}" name=" tlp_rumah"
                                                            class="form-control" placeholder="Silahkan Entry Telephone"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Penghasilan
                                                        Perbulan</label>
                                                    <div class="col-md-4">
                                                        <input type="text" value="{{ $penghasilan_perbulan }}"
                                                            name="penghasilan_perbulan" class="number_format form-control"
                                                            placeholder="Silahkan Entry Penghasilan Perbulan" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Penghasilan Pertahun
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" placeholder="penghasilan_pertahun .."
                                                            value="{{ $penghasilan_pertahun }}"
                                                            name="penghasilan_pertahun" class="number_format form-control"
                                                            placeholder="Silahkan Entry Penghasilan Pertahun" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Status </label>
                                                    <div class="col-md-4">
                                                        <select name="status" class="form-control">
                                                            <option value="1">Menikah</option>
                                                            <option value="2">Belum Menikah</option>
                                                        </select>
                                                    </div>

                                                    <label for="name" class="col-md-2 text-left">Status
                                                        pernikahan</label>
                                                    <div class="col-md-4">
                                                        <select name="status_pernikahan_ktp" class="form-control">
                                                            <option value="Menikah">Kawin</option>
                                                            <option value="Belum Menikah">Belum Kawin</option>
                                                            <option value="Cerai Hidup">Cerai Hidup</option>
                                                            <option value="Cerai">Carai Mati</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Pengeluaran
                                                        Pertahun</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="pengeluaran_pertahun"
                                                            value="{{ Tmparamtertr::curency($pengeluaran_pertahun) }}"
                                                            class="number_format form-control"
                                                            placeholder="Silahkan Entry Pengeluaran Pertahun" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Status tempat
                                                        tinggal</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="status_tempat_tinggal">
                                                            <option value="Milik Sendiri">Milik Sendiri</option>
                                                            <option value="Orang Tua">Orang Tua</option>
                                                            <option value="Kontrak / Kost">Kontrak / Kost</option>
                                                            <option value="Tempat Tinggal lainya">Tempat Tinggal lainya
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group row">

                                                    <label for="name" class="col-md-2 text-left">Jumlah
                                                        Tanggungan</label>
                                                    <div class="col-md-4">
                                                        <input type="number" name="jumlah_tanggungan"
                                                            value="{{ $jumlah_tanggungan }}" class="form-control"
                                                            placeholder="Silahkan Entry Jumlah Tanggungan" required>
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Tujuan Penggunaan
                                                        Dana</label>
                                                    <div class="col-md-4">
                                                        <textarea name="tujuan_penggunaan" class="form-control" cols="4"
                                                            rows="10">{{ $tujuan_penggunaan }}</textarea>
                                                    </div>

                                                </div>

                                                <hr />
                                                <h3 class="section-title">Data Tempat Tinggal
                                                </h3>
                                                <div class="form-group row">

                                                    <label for="name" class="col-md-2 text-left">Rt / RW</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="rt_rw_ktp" value="{{ $rt_rw_ktp }}"
                                                            class="form-control" placeholder="Silahkan Entry RT/RW KTP"
                                                            required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Kelurahan Berdasarkan
                                                        KTP</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kelurahan_ktp"
                                                            value="{{ $kelurahan_ktp }}" class="form-control"
                                                            placeholder="Silahkan Entry Kelurahan" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">


                                                    <label for="name" class="col-md-2 text-left">Provinsi</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="provinsi_ktp"
                                                            value="{{ $provinsi_ktp }}" class="form-control"
                                                            placeholder="Silahkan Entry Provinsi" required>
                                                    </div>

                                                    <label for="name" class="col-md-2 text-left">Kota / Kabupaten
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kota_kabupaten_ktp"
                                                            value="{{ $kota_kabupaten_ktp }}" class="form-control"
                                                            placeholder="Silahkan Entry Kota / Kabupaten" required>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Kecamatan</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kecamatan_ktp"
                                                            value="{{ $kecamatan_ktp }}" class="form-control"
                                                            placeholder="Silahkan Entry Kecamatan" required>
                                                    </div>


                                                    <label for="name" class="col-md-2 text-left">Kota / Kabupaten
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kota_kabupaten_ktp"
                                                            value="{{ $kota_kabupaten_ktp }}" class="form-control"
                                                            placeholder="Silahkan Entry Kota / Kabupaten" required>
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Kode POS</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kode_pos_ktp"
                                                            value="{{ $kode_pos_ktp }}" class="form-control"
                                                            placeholder="Silahkan Entry Kode Pos" required>
                                                    </div>

                                                </div>

                                                <hr />
                                                <h3 class="section-title">Data domisili</h3>
                                                <br />
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Alamat domisili</label>
                                                    <div class="col-md-4">
                                                        <textarea class="form-control" name="alamat_domisili" cols="15"
                                                            rows="12"
                                                            placeholder="Alamat domisili">{{ $alamat_domisili }}</textarea>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">RT / RW
                                                        Domisili</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="rt_rw_domisili"
                                                            value="{{ $rt_rw_domisili }}" class="form-control"
                                                            placeholder="Silahkan Entry RT/RW Domisili" required>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Kelurahan
                                                        Domisili</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kelurahan_domisili" class="form-control"
                                                            value="{{ $kelurahan_domisili }}"
                                                            placeholder="Silahkan Entry Kelurahan Domisili" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Kecamatan
                                                        Domisili</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kecamatan_domisili" class="form-control"
                                                            value="{{ $kecamatan_domisili }}"
                                                            placeholder="Silahkan Entry Kecamatan Domisili" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Kota Kabupaten
                                                        Domisli</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kota_kabupaten_domisili"
                                                            class="form-control" value="{{ $kota_kabupaten_domisili }}"
                                                            placeholder="Silahkan Entry Kota / Kabupaten Domisili" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Provinsi
                                                        Domisli</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="provinsi_domisili"
                                                            value="{{ $provinsi_domisili }}" class="form-control"
                                                            placeholder="Silahkan Entry Provinsi Domisili" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">

                                                    <label for="name" class="col-md-2 text-left">Kode Pos
                                                        Domisili</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kode_pos_domisili"
                                                            value="{{ $kode_pos_domisili }}" class="form-control"
                                                            placeholder="Silahkan Entry Kode Pos Domisili" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Jenis Penduduk</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="jenis_penduduk"
                                                            value="{{ $jenis_penduduk }}" class="form-control"
                                                            placeholder="Silahkan Entry Jenis Penduduk" required>
                                                    </div>
                                                </div>

                                                <hr />
                                                <h3 class="section-title">Data Kewarganegaraan</h3>

                                                <br />
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Kewarganegaraan</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="kewarganegaraan">
                                                            <option value="WNI">Warga Negara Indonesia (WNI)</option>
                                                            <option value="WNA">Warga Negara Asing (WNA)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- endstatemen --}}
                                            <div id="parameter" role="tabpanel" aria-labelledby="parameter-tab"
                                                class="tab-pane fade px-4 py-5">
                                                <div class="form-group row">
                                                    <label for="jum_penerima_manfaat" class="col-md-4 text=left">Jumlah
                                                        Penerima
                                                        manfaat</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" name="jumlah_penerima_manfaat"
                                                            id="jumlah_penerima_manfaat">
                                                            <option value="">Pilih Penerima Manfaat</option>
                                                            @for ($a = 1; $a <= 8; $a++)
                                                                @php
                                                                    $selected = $jumlah_penerima_manfaat == $a ? 'selected' : '';
                                                                @endphp
                                                                <option value="{{ $a }}" {{ $selected }}
                                                                    disabled>
                                                                    {{ $a }}
                                                                </option>
                                                            @endfor
                                                        </select>

                                                    </div>

                                                </div>

                                                <div class="jumlah_nya"></div>
                                            </div>

                                            <div id="phadiah" role="tabpanel" aria-labelledby="phadiah-tab"
                                                class="tab-pane fade px-4 py-5">

                                            </div>

                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-primary btn-lg mr-1" type="submit" id="simpan_form"><i
                                                    class="fas fa-save"></i>Simpan data</button>
                                            <button class="btn btn-danger btn-lg" type="reset" data-dismiss="modal"><i
                                                    class="fas fa-share"></i>Reset</button>
                                        </div>
                                    </form>

                                    <!-- End rounded tabs -->
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
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

            $('#tmparameter_id').on('change', function() {
                var idfilenya = $(this).val();
                var htmlnya = '<br /><a href="#" onclick="javascript:detailparameter(' + idfilenya +
                    ')" class="btn btn-primary" datanya="' +
                    idfilenya +
                    '">Detail data progam</a>';
                $('.detail_program').html(htmlnya);

            });


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
                        success: function(json) {
                            // json = JSON.parse(data);
                            if (json.msg_overide.pmanfaat != '' || json.msg_overide.peserta !=
                                '') {
                                $.confirm({
                                    title: 'Terdapat data yang harus di overide ',
                                    content: 'Beberapa syarat pengajuan tidak dapat di lanjutkan',
                                    type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        tryAgain: {
                                            text: 'Try again',
                                            btnClass: 'btn-red',
                                            action: function() {
                                                window.location.href =
                                                    '{{ route('overide.index') }}';
                                            }
                                        },
                                        close: function() {
                                            window.location.href =
                                                '{{ route('overide.index') }}';
                                        }
                                    }
                                });
                            }
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
                useBootstrap: false,
                backgroundDismiss: true,
            });
        }

        function umur() {
            var dateString = document.getElementById('tanggal_lahir_ktp').value;
            var today = new Date();
            var birthDate = new Date(dateString);
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            var theBday = document.getElementById('umur_peserta');
            theBday.value = age;
        }

        $(function() {
            if ({{ $overide_status }} == 2) {
                $('.cstatus').hide();
            } else {
                $('.cstatus').show();
            }
            $('select[name="status"]').on('change', function(e) {
                e.preventDefault();
                if ($(this).val() == 2) {
                    $('.cstatus').hide();
                } else {
                    $('.cstatus').show();
                }
            })

        });

        var idfilenya = "{{ $tmparameter_id }}";
        var htmlnya = '<br /><a href="#" onclick="javascript:detailparameter(' + idfilenya +
            ')" class="btn btn-primary" datanya="' +
            idfilenya +
            '">Detail data progam</a>';
        $('.detail_program').html(htmlnya);

        $('#tmparameter_id').on('change', function() {
            var idfilenya = $(this).val();
            var htmlnya = '<br /><a href="#" onclick="javascript:detailparameter(' + idfilenya +
                ')" class="btn btn-primary" datanya="' +
                idfilenya +
                '">Detail data progam</a>';
            $('.detail_program').html(htmlnya);

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
    </script>
@endsection
