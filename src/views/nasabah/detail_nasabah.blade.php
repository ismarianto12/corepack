<hr />
<h3 class="section-title">Data Personal (Pribadi)
</h3>
<div class="form-group row">
    <input type="hidden" name="nasabah" value="nasabah">
    <label for="name" class="col-md-2 text-left">No Ismarianto</label>
    <div class="col-md-4">
        <input type="text" class="form-control" placeholder="no_aplikasi .." value="{{ $no_aplikasi }}" readonly>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Nomor KTP / NIK</label>
    <div class="col-md-4">
        <input type="number" name="no_ktp" class="form-control" placeholder="no_ktp .." value="{{ $no_ktp }}"
            required>
    </div>
    <label for="name" class="col-md-2 text-left">Nama Ibu Kandung KTP</label>
    <div class="col-md-4">
        <input type="text" name="nama_ibu_kandung_ktp" class="form-control" placeholder="nama_ibu_kandung_ktp .."
            value="{{ $nama_ibu_kandung_ktp }}" required>
    </div>
</div>

<div class="form-group row">

    <label for="name" class="col-md-2 text-left">Nama Sesuai KTP</label>
    <div class="col-md-4">
        <input type="text" name="nama_sesuai_ktp" class="form-control" placeholder="nama_sesuai_ktp .."
            value="{{ $nama_sesuai_ktp }}" required>
    </div>

</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Tempat Lahir</label>
    <div class="col-md-4">
        <input type="text" name="tempat_lahir_ktp" class="form-control" placeholder="tempat_lahir_ktp .."
            value="{{ $tempat_lahir_ktp }}" required>
    </div>
    <label for="name" class="col-md-2 text-left">Tanggal Lahir KTP</label>
    <div class="col-md-4">
        <input type="text" name="tanggal_lahir_ktp" class="form-control" placeholder="tanggal_lahir_ktp .."
            value="{{ $tanggal_lahir_ktp }}" required>
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
        <input type="text" name="pekerjaan_ktp" class="form-control" placeholder="pekerjaan_ktp .."
            value="{{ $pekerjaan_ktp }}" required>
    </div>
</div>


<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Status pernikahan</label>
    <div class="col-md-4">
        <input type="text" name="status_pernikahan_ktp" class="form-control" placeholder="status_pernikahan_ktp .."
            value="{{ $status_pernikahan_ktp }}" required>
    </div>
    <label for="name" class="col-md-2 text-left">Alamat Sesuai KTP</label>
    <div class="col-md-4">
        <input type="text" name="alamat_sesuai_ktp" class="form-control" placeholder="alamat_sesuai_ktp .."
            value="{{ $alamat_sesuai_ktp }}" required>
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
        <input type="text" name="no_hp" class="form-control" placeholder="No Handphone .." value="{{ $no_hp }}"
            required>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Email</label>
    <div class="col-md-4">
        <input type="email" name="email" class="form-control" placeholder="Email .." value="{{ $email }}"
            required>
    </div>
    <label for="name" class="col-md-2 text-left">Telephone</label>
    <div class="col-md-4">
        <input type="number" name="tlp_rumah" class="form-control" placeholder="Telephone .."
            value="{{ $tlp_rumah }}" required>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Penghasilan Perbulan</label>
    <div class="col-md-4">
        <input type="text" name="penghasilan_perbulan" class="number_format form-control"
            placeholder="penghasilan_perbulan .." value="{{ $penghasilan_perbulan }}" required>
    </div>
    <label for="name" class="col-md-2 text-left">Penghasilan Pertahun </label>
    <div class="col-md-4">
        <input type="text" name="penghasilan_pertahun" class="number_format form-control"
            placeholder="penghasilan_pertahun .." value="{{ $penghasilan_pertahun }}" required>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Pengeluaran Pertahun</label>
    <div class="col-md-4">
        <input type="text" name="pengeluaran_pertahun" class="number_format form-control"
            placeholder="Pengeluarn Pertahun .." value="{{ $pengeluaran_pertahun }}" required>
    </div>
    <label for="name" class="col-md-2 text-left">Status tempat tinggal</label>
    <div class="col-md-4">
        <input type="text" name="status_tempat_tinggal" class="form-control" placeholder="Status Tempat Tinggal .."
            value="{{ $status_tempat_tinggal }}" required>
    </div>
</div>


<div class="form-group row">

    <label for="name" class="col-md-2 text-left">Jumlah Tanggungan</label>
    <div class="col-md-4">
        <input type="text" name="jumlah_tanggungan" class="form-control" placeholder="Jumlah Tanggungan .."
            value="{{ $jumlah_tanggungan }}" required>
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
        <input type="text" name="nama_kelurahan" class="form-control" placeholder="Nama Kelurahan .."
            value="{{ $nama_kelurahan }}" required>
    </div>
</div>

<div class="form-group row">

    <label for="name" class="col-md-2 text-left">Umur Peserta</label>
    <div class="col-md-4">
        <input type="number" name="umur_peserta" class="form-control" placeholder="umur_peserta .."
            value="{{ $umur_peserta }}" required>
    </div>
    <label for="name" class="col-md-2 text-left">Status Peserta </label>
    <div class="col-md-4">
        <input type="text" name="status_peserta" class="form-control" placeholder="status_peserta .."
            value="{{ $status_peserta }}" required>
    </div>
</div>

<hr />
<h3 class="section-title">Data Tempat Tinggal
</h3>
<div class="form-group row">

    <label for="name" class="col-md-2 text-left">Rt / RW</label>
    <div class="col-md-4">
        <input type="text" name="rt_rw_ktp" class="form-control" placeholder="rt_rw_ktp .." value="{{ $rt_rw_ktp }}"
            required>
    </div>
    <label for="name" class="col-md-2 text-left">Kelurahan Berdasarkan KTP</label>
    <div class="col-md-4">
        <input type="text" name="kelurahan_ktp" class="form-control" placeholder="kelurahan_ktp .."
            value="{{ $kelurahan_ktp }}" required>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Kecamatan</label>
    <div class="col-md-4">
        <input type="text" name="kecamatan_ktp" class="form-control" placeholder="kecamatan_ktp .."
            value="{{ $kecamatan_ktp }}" required>
    </div>
    <label for="name" class="col-md-2 text-left">Kota / Kabupaten </label>
    <div class="col-md-4">
        <input type="text" name="kota_kabupaten_ktp" class="form-control" placeholder="kota_kabupaten_ktp .."
            value="{{ $kota_kabupaten_ktp }}" required>
    </div>

</div>
<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Provinsi</label>
    <div class="col-md-4">
        <input type="text" name="provinsi_ktp" class="form-control" placeholder="provinsi_ktp .."
            value="{{ $provinsi_ktp }}" required>
    </div>
    <label for="name" class="col-md-2 text-left">Kode POS</label>
    <div class="col-md-4">
        <input type="text" name="kode_pos_ktp" class="form-control" placeholder="kode_pos_ktp .."
            value="{{ $kode_pos_ktp }}" required>
    </div>
</div>

<hr />
<h3 class="section-title">Data domisili</h3>
<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Alamat domisili</label>
    <div class="col-md-4">
        <input type="text" name="alamat_domisili" class="form-control" placeholder="alamat_domisili .."
            value="{{ $alamat_domisili }}" required>
    </div>
    <label for="name" class="col-md-2 text-left">RT / rw Domisili</label>
    <div class="col-md-4">
        <input type="text" name="rt_rw_domisili" class="form-control" placeholder="rt_rw_domisili .."
            value="{{ $rt_rw_domisili }}" required>
    </div>
</div>


<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Kelurahan Domisili</label>
    <div class="col-md-4">
        <input type="text" name="kelurahan_domisili" class="form-control" placeholder="kelurahan_domisili .."
            value="{{ $kelurahan_domisili }}" required>
    </div>
    <label for="name" class="col-md-2 text-left">Kecamatan Domisili</label>
    <div class="col-md-4">
        <input type="text" name="kecamatan_domisili" class="form-control" placeholder="kecamatan_domisili .."
            value="{{ $kecamatan_domisili }}" required>
    </div>
</div>


<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Kota Kabupaten Domisli</label>
    <div class="col-md-4">
        <input type="text" name="kota_kabupaten_domisili" class="form-control" placeholder="kota_kabupaten_domisili .."
            value="{{ $kota_kabupaten_domisili }}" required>
    </div>
    <label for="name" class="col-md-2 text-left">Provinsi Domisli</label>
    <div class="col-md-4">
        <input type="text" name="provinsi_domisili" class="form-control" placeholder="provinsi_domisili .."
            value="{{ $provinsi_domisili }}" required>
    </div>
</div>
<div class="form-group row">

    <label for="name" class="col-md-2 text-left">Kode Pos Domisili</label>
    <div class="col-md-4">
        <input type="text" name="kode_pos_domisili" class="form-control" placeholder="kode_pos_domisili .."
            value="{{ $kode_pos_domisili }}" required>
    </div>
    <label for="name" class="col-md-2 text-left">Jenis Penduduk</label>
    <div class="col-md-4">
        <input type="text" name="jenis_penduduk" class="form-control" placeholder="jenis_penduduk .."
            value="{{ $jenis_penduduk }}" required>
    </div>
</div>

<hr />
<h3 class="section-title">Data Kewarganegaraan</h3>


<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Kewarganegaraan</label>
    <div class="col-md-4">
        {{ $kewarganegaraan }}
    </div>
</div>

<h3 class="section-title">Data Penerima manfaat</h3>
