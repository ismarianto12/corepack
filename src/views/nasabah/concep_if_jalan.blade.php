@extends('ismarianto::layouts.template')

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
                                                <hr />
                                                <h3 class="section-title">Pilihan Program
                                                </h3>
                                                <br />
                                                <div class="form-group row">
                                                    <input type="hidden" name="nasabah" value="nasabah">
                                                    <label for="name" class="col-md-2 text-left">No Ismarianto</label>
                                                    <input type="hidden" value="{{ Tmparamtertr::generate() }}"
                                                        name="no_aplikasi">
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control" placeholder=""
                                                            value="{{ Tmparamtertr::generate() }}" readonly>
                                                    </div>
                                                </div>

                                                <div class="form-group row">

                                                    <label for="tujuan_penggunaan" class="col-md-2 text=left">Program
                                                        Tazam</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="tmparameter_id"
                                                            id="tmparameter_id" required>
                                                            <option value="">--Pilihan program--</option>
                                                            @foreach ($program as $programs)
                                                                <option value="{{ $programs->id }}">
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
                                                                <option value="{{ $tmhadiahs->id }}">
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
                                                            placeholder="Silahkan Entry No KTP" required>
                                                    </div>
                                                    <br />

                                                    <label for="name" class="col-md-2 text-left">Nama Ibu Kandung
                                                        KTP</label>
                                                    <br />
                                                    <div class="col-md-4">
                                                        <input type="text" name="nama_ibu_kandung_ktp" class="form-control"
                                                            placeholder="Silahkan Entry Nama Ibu Kandung" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Nama Sesuai KTP</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="nama_sesuai_ktp" class="form-control"
                                                            placeholder="Silahkan Entry Nama" required>
                                                    </div>

                                                    <label for="name" class="col-md-2 text-left">Tanggal Lahir
                                                        KTP</label>
                                                    <div class="col-md-4">
                                                        <input type="date" name="tanggal_lahir_ktp" id="tanggal_lahir_ktp"
                                                            class="form-control" placeholder="Silahkan Entry Tanggal Lahir"
                                                            onchange="umur()" required>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Tempat Lahir</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="tempat_lahir_ktp" class="form-control"
                                                            placeholder="Silahkan Entry Tempat Lahir" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Umur Peserta</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="umur_peserta"
                                                            class="number_format form-control"
                                                            placeholder="Umur Sesuai tanggal lahir otomatis"
                                                            id="umur_peserta" readonly required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Jenis Kelamin</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="jenis_kelamin_ktp">
                                                            <option value="L">Laki laki</option>
                                                            <option value="P">Perempuan</option>
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
                                                        <input type="number" name="no_hp" class="form-control"
                                                            placeholder="Silahkan Entry No.Handphone" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Email</label>
                                                    <div class="col-md-4">
                                                        <input type="email" name="email" class="form-control"
                                                            placeholder="Silahkan Entry Email" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Telephone</label>
                                                    <div class="col-md-4">
                                                        <input type="number" name="tlp_rumah" class="form-control"
                                                            placeholder="Silahkan Entry Telephone" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Penghasilan
                                                        Perbulan</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="penghasilan_perbulan"
                                                            class="number_format form-control"
                                                            placeholder="Silahkan Entry Penghasilan Perbulan" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Penghasilan Pertahun
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="penghasilan_pertahun"
                                                            class="number_format form-control"
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


                                                <div class="cstatus form-group row">
                                                    <label for="name" class="col-md-2 text-left">Status
                                                        pernikahan</label>
                                                    <div class="col-md-4">
                                                        <select name="status_pernikahan_ktp" class="form-control">
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
                                                            class="number_format form-control"
                                                            placeholder="Silahkan Entry Pengeluaran Pertahun" required>
                                                    </div>

                                                    <label for="name" class="col-md-2 text-left">Jumlah
                                                        Tanggungan</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="jumlah_tanggungan" class="form-control"
                                                            placeholder="Silahkan Entry Jumlah Tanggungan" required>
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Tujuan Penggunaan
                                                        Data</label>
                                                    <div class="col-md-4">
                                                        <textarea name="tujuan_penggunaan" class="form-control" cols="4"
                                                            rows="10">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              </textarea>
                                                    </div>

                                                </div>

                                                <hr />
                                                <h3 class="section-title">Data Tempat Tinggal
                                                </h3>
                                                <div class="form-group row">

                                                    <label for="name" class="col-md-2 text-left">Rt / RW</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="rt_rw_ktp" class="form-control"
                                                            placeholder="Silahkan Entry RT/RW KTP" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Kelurahan Berdasarkan
                                                        KTP</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kelurahan_ktp" class="form-control"
                                                            placeholder="Silahkan Entry Kelurahan" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">


                                                    <label for="name" class="col-md-2 text-left">Provinsi</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="provinsi_ktp" class="form-control"
                                                            placeholder="Silahkan Entry Provinsi" required>
                                                    </div>

                                                    <label for="name" class="col-md-2 text-left">Kota / Kabupaten
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kota_kabupaten_ktp" class="form-control"
                                                            placeholder="Silahkan Entry Kota / Kabupaten" required>
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Kecamatan</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kecamatan_ktp" class="form-control"
                                                            placeholder="Silahkan Entry Kecamatan" required>
                                                    </div>


                                                    <label for="name" class="col-md-2 text-left">Kota / Kabupaten
                                                    </label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kota_kabupaten_ktp" class="form-control"
                                                            placeholder="Silahkan Entry Kota / Kabupaten" required>
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Kode POS</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kode_pos_ktp" class="form-control"
                                                            placeholder="Silahkan Entry Kode Pos" required>
                                                    </div>
                                                </div>
                                                <hr />
                                                <h3 class="section-title">Data domisili</h3>
                                                <br />
                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Alamat domisili</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="alamat_domisili" class="form-control"
                                                            placeholder="Silahkan Entry Alamat Domisili" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">RT / RW
                                                        Domisili</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="rt_rw_domisili" class="form-control"
                                                            placeholder="Silahkan Entry RT/RW Domisili" required>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Kelurahan
                                                        Domisili</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kelurahan_domisili" class="form-control"
                                                            placeholder="Silahkan Entry Kelurahan Domisili" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Kecamatan
                                                        Domisili</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kecamatan_domisili" class="form-control"
                                                            placeholder="Silahkan Entry Kecamatan Domisili" required>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label for="name" class="col-md-2 text-left">Kota Kabupaten
                                                        Domisli</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kota_kabupaten_domisili"
                                                            class="form-control"
                                                            placeholder="Silahkan Entry Kota / Kabupaten Domisili" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Provinsi
                                                        Domisli</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="provinsi_domisili" class="form-control"
                                                            placeholder="Silahkan Entry Provinsi Domisili" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">

                                                    <label for="name" class="col-md-2 text-left">Kode Pos
                                                        Domisili</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="kode_pos_domisili" class="form-control"
                                                            placeholder="Silahkan Entry Kode Pos Domisili" required>
                                                    </div>
                                                    <label for="name" class="col-md-2 text-left">Jenis Penduduk</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="jenis_penduduk" class="form-control"
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
                                            {{-- <div class="form-group row">
                                                    <label for="jum_penerima_manfaat" class="col-md-4 text=left">Jumlah
                                                        Penerima
                                                        manfaat</label>
                                                    <div class="col-md-8">
                                                        <select class="form-control" name="jumlah_penerima_manfaat"
                                                            id="jumlah_penerima_manfaat">
                                                            <option value="">Pilih Penerima Manfaat</option>
                                                            @for ($a = 1; $a <= 8; $a++)

                                                                <option value="">
                                                                    
                                                                </option>
                                                            @endfor
                                                        </select>

                                                    </div>

                                                </div>

                                                <div class="jumlah_nya"></div>
                                            </div> --}}

                                            <div id="parameter" role="tabpanel" aria-labelledby="parameter-tab"
                                                class="tab-pane fade px-4 py-5">
                                                <hr />
                                                <div id="repeater">
                                                    <div class="repeater-heading">
                                                        <a href="#" class="repeater-add-btn btn btn-primary"><i
                                                                class="fas fa-plus"></i>Tambah</a>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <!-- Repeater Items -->
                                                    <div class="items" data-group="test">
                                                        <div class="item-content">
                                                            <div class="pull-right repeater-remove-btn"
                                                                style="margin-top:20px">
                                                                <button id="remove-btn" class="btn btn-danger"
                                                                    onclick="$(this).parents('.items').remove()">
                                                                    Remove
                                                                </button>
                                                            </div>
                                                            <h2 class="section-title">Data Penerima Manfaat Ke - <div
                                                                    clcass="angka"></div>
                                                            </h2>
                                                            <br />
                                                            * ) Maksimal penerima manfaat 8
                                                            <br />
                                                            <div class="form-group row">
                                                                <label for="name" class="col-md-2 text=left">Nama
                                                                    Penerima Manfaat
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input required class="form-control"
                                                                        name="nama_penerima_manfaat_" id="name">
                                                                    <div class="invalid-feedback">
                                                                        Please Entry Nama Penerima Manfaat
                                                                    </div>
                                                                </div>

                                                                <label for="usia" class="col-md-2 text=left">Usia
                                                                    Penerima manfaat
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input required type="text" max="2"
                                                                        name="usia_penerima_manfaat_"
                                                                        class="number_format form-control"
                                                                        id="usia_penerima_manfaat_" readonly>
                                                                    <div class="invalid-feedback">
                                                                        Maksimal . 2 Digit
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="name" class="col-md-2 text-left">Tanggal
                                                                    Lahir</label>
                                                                <div class="col-md-4">
                                                                    <input type="date" name="tgl_lahir_" id="tgl_lahir_"
                                                                        class="form-control"
                                                                        placeholder="Silahkan Entry Tanggal Lahir"
                                                                        onchange="umur()" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">

                                                                <label for="hubungan" class="col-md-2 text=left">Hubungan
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control"
                                                                        name="hubungan_penerima_manfaat_" required>
                                                                        <option value=""></option>
                                                                        @foreach ($hubungan as $hubungans)
                                                                            <option
                                                                                value="{{ $hubungans->nama_hubungan }}">
                                                                                {{ $hubungans->nama_hubungan }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>


                                                                    <div class="invalid-feedback">
                                                                        Please Entry Hubungan
                                                                    </div>
                                                                </div>

                                                                <label for="pilihan_hadiah"
                                                                    class="col-md-2 text=left">Pilihan
                                                                    Hadiah</label>
                                                                <div class="col-md-4">
                                                                    <select class="form-control"
                                                                        name="pilihan_hadiah_penerima_manfaat_" required>
                                                                        <option value=""></option>
                                                                        @foreach ($tmhadiah as $tmhadiahs)
                                                                            <option value="{{ $tmhadiahs->id }}">
                                                                                {{ $tmhadiahs->jenis_hadiah }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="invalid-feedback">
                                                                        Please Entry Pilihan Hadiah
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">

                                                                <label for="no_hp" class="col-md-2 text=left">No Hp
                                                                </label>
                                                                <div class="col-md-4">
                                                                    <input required class="form-control"
                                                                        name="no_hp_penerima_manfaat_" id="no_hp"
                                                                        type="number">
                                                                    <div class="invalid-feedback">
                                                                        Please Entry No Handphone
                                                                    </div>
                                                                </div>

                                                                <label for="email" class="col-md-2 text=left">Email</label>
                                                                <div class="col-md-4">
                                                                    <input required type="email"
                                                                        name="email_penerima_manfaat_" class="form-control"
                                                                        id="email">
                                                                    <div class="invalid-feedback">
                                                                        Please Entry Email
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="alamat"
                                                                    class="col-md-2 text=left">Alamat</label>
                                                                <div class="col-md-4">
                                                                    <textarea class="form-control"
                                                                        name="alamat_penerima_manfaat_" id="alamat"
                                                                        cols="12" rows="20" required></textarea>
                                                                    <div class="invalid-feedback">
                                                                        Please Entry Alamat
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- Repeater Remove Btn -->

                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <!-- Repeater End -->





                                            </div>
                                            <div class="card-footer text-right">
                                                <button class="btn btn-primary btn-lg mr-1" type="submit"
                                                    id="simpan_form"><i class="fas fa-save"></i>Simpan data</button>
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
    <script>
        jQuery.fn.extend({
            createRepeater: function() {
                var addItem = function(items, key) {
                    var itemContent = items;
                    var group = itemContent.data("group");
                    var item = itemContent;
                    var input = item.find('input,select');
                    input.each(function(index, el) {
                        var attrName = $(el).data('name');
                        var skipName = $(el).data('skip-name');
                        if (skipName != true) {
                            $(el).attr("name", group + "[" + key + "]" + attrName);
                        } else {
                            if (attrName != 'undefined') {
                                $(el).attr("name", attrName);
                            }
                        }
                    })
                    var itemClone = items;
                    $("<div class='items'>" + itemClone.html() + "<div/>").appendTo(repeater);
                };
                /* find elements */
                var repeater = this;
                var items = repeater.find(".items");
                var key = 0;
                var addButton = repeater.find('.repeater-add-btn');
                var newItem = items;
                if (key == 0) {
                    items.remove();
                    addItem(newItem, key);
                }

                /* handle click and add items */
                addButton.on("click", function() {
                    key++;
                    addItem(newItem, key);
                });
            }
        });
        $("#repeater").createRepeater();
    </script>

    <script>
        function umur() {
            var dateString = document.getElementById('tgl_lahir_').value;
            var today = new Date();
            var birthDate = new Date(dateString);
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            var theBday = document.getElementById('usia_penerima_manfaat_');
            theBday.value = age;
        }
    </script>

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
            // get data jumlah nya berapa  

            $('#tmparameter_id').on('change', function() {
                var idfilenya = $(this).val();
                var htmlnya = '<br /><a href="#" onclick="javascript:detailparameter(' + idfilenya +
                    ')" class="btn btn-primary" datanya="' +
                    idfilenya +
                    '">Detail data progam</a>';
                $('.detail_program').html(htmlnya);

            });


            var no_aplikasi = '';
            $('#jumlah_penerima_manfaat').on('change', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('nasabah.penerima_manfaat') }}",
                    method: "POST",
                    data: 'jumlah_penerima_manfaat=' + $(this).val() + '&no_aplikasi=' +
                        no_aplikasi,
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
                $('#simpan_form').addClass('btn disabled btn-progress');
                if ($(this)[0].checkValidity() === false) {
                    e.preventDefault();
                    e.stopPropagation();
                    $('#simpan_form').removeClass(
                        'disabled btn-progress');
                } else {
                    $('#simpan_form').addClass('btn disabled btn-progress');
                    $.ajax({
                        url: "{{ route('nasabah.store') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        chace: false,
                        async: false,
                        dataType: 'json',
                        success: function(json) {
                            if (json.msg_overide.pmanfaat != '' || json.msg_overide.peserta !=
                                '') {
                                $.confirm({
                                    title: 'Terdapat data yang harus di overide ',
                                    content: 'Beberapa syarat pengajuan tidak dapat di lanjutkan',
                                    type: 'red',
                                    typeAnimated: true,
                                    buttons: {
                                        tryAgain: {
                                            text: 'Ok',
                                            btnClass: 'btn-red',
                                            action: function() {
                                                window.location.href =
                                                    '{{ route('overide.index') }}';
                                            }
                                        }
                                    }
                                });
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Data berhasil di simpan',
                                    showConfirmButton: false,
                                    timer: 100
                                });
                                window.location.href = '{{ route('nasabah.index') }}';
                            }
                        },
                        error: function(data, JqxHR, status) {
                            // var div = $('#container');
                            // setInterval(function() {
                            //     var pos = div.scrollTop();
                            //     div.scrollTop(pos + 2);
                            // }, 10)
                            // err = '';

                            // respon = data.responseJSON;
                            // $.each(respon.errors, function(index, value) {
                            //     err += "<li>" + value + "</li>";
                            // }); 
                            swal.fire(error, JqxHR, status);
                            //  $('.ket').html(
                            //      "<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Perahtian donk!</strong> " +
                            //      respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");


                        }
                    })
                }
            });
        });
        // status data 
        $(function() {
            $('.cstatus').hide();
            $('select[name="status"]').on('change', function(e) {
                e.preventDefault();
                if ($(this).val() == 2) {
                    $('.cstatus').hide();
                } else {
                    $('.cstatus').show();
                }
            })

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
    </script>
@endsection
