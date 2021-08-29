<hr />
<h3 class="section-title">Data Personal (Pribadi)
</h3>
<div class="form-group row">
    <label for="name" class="col-md-2 text-left">No Aplikasi Peserta</label>
    <div class="col-md-4">
        <input type="text" class="form-control" placeholder="no_aplikasi .." value="{{ $no_aplikasi }}" readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Program Di Pilih</label>
    <div class="col-md-4">
        <small>{{ base64_decode('S2xpayBidXR0b24gdW50dWsgbWVsaWhhdCBkZXRhaWwgcHJvZ3JhbSB5YW5nIGRpIHBpbGlo') }}</small>
        <br />{{ $tmparametername }}
        <div class="detail_program"></div>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Nomor KTP / NIK</label>
    <div class="col-md-4">
        <input type="number" name="no_ktp" class="form-control" placeholder="no_ktp .." value="{{ $no_ktp }}"
            readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Nama Ibu Kandung KTP</label>
    <div class="col-md-4">
        <input type="text" name="nama_ibu_kandung_ktp" class="form-control" placeholder="nama_ibu_kandung_ktp .."
            value="{{ $nama_ibu_kandung_ktp }}" readonly>
    </div>
</div>

<div class="form-group row">

    <label for="name" class="col-md-2 text-left">Nama Sesuai KTP</label>
    <div class="col-md-4">
        <input type="text" name="nama_sesuai_ktp" class="form-control" placeholder="nama_sesuai_ktp .."
            value="{{ $nama_sesuai_ktp }}" readonly>
    </div>

</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Tempat Lahir</label>
    <div class="col-md-4">
        <input type="text" name="tempat_lahir_ktp" class="form-control" placeholder="tempat_lahir_ktp .."
            value="{{ $tempat_lahir_ktp }}" readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Tanggal Lahir KTP</label>
    <div class="col-md-4">
        <input type="text" name="tanggal_lahir_ktp" class="form-control" placeholder="tanggal_lahir_ktp .."
            value="{{ $tanggal_lahir_ktp }}" readonly>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Jenis Kelamin</label>
    <div class="col-md-4">
        {{ $jenis_kelamin_ktp == 'L' ? 'Laki - Laki' : 'Perempuan' }}
    </div>
    <label for="name" class="col-md-2 text-left">Pekerjaan KTP</label>
    <div class="col-md-4">
        <input type="text" name="pekerjaan_ktp" class="form-control" placeholder="pekerjaan_ktp .."
            value="{{ $pekerjaan_ktp }}" readonly>
    </div>
</div>


<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Status pernikahan</label>
    <div class="col-md-4">
        <input type="text" name="status_pernikahan_ktp" class="form-control" placeholder="status_pernikahan_ktp .."
            value="{{ $status_pernikahan_ktp }}" readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Alamat Sesuai KTP</label>
    <div class="col-md-4">
        <input type="text" name="alamat_sesuai_ktp" class="form-control" placeholder="alamat_sesuai_ktp .."
            value="{{ $alamat_sesuai_ktp }}" readonly>
    </div>
</div>



<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Agama</label>
    <div class="col-md-4">
        {{ $agama }}
    </div>
    <label for="name" class="col-md-2 text-left">No Handphone</label>
    <div class="col-md-4">
        <input type="text" name="no_hp" class="form-control" placeholder="No Handphone .." value="{{ $no_hp }}"
            readonly>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Email</label>
    <div class="col-md-4">
        <input type="email" name="email" class="form-control" placeholder="Email .." value="{{ $email }}"
            readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Telephone</label>
    <div class="col-md-4">
        <input type="number" name="tlp_rumah" class="form-control" placeholder="Telephone .."
            value="{{ $tlp_rumah }}" readonly>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Penghasilan Perbulan</label>
    <div class="col-md-4">
        <input type="text" name="penghasilan_perbulan" class="number_format form-control"
            placeholder="penghasilan_perbulan .." value="{{ $penghasilan_perbulan }}" readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Penghasilan Pertahun </label>
    <div class="col-md-4">
        <input type="text" name="penghasilan_pertahun" class="number_format form-control"
            placeholder="penghasilan_pertahun .." value="{{ $penghasilan_pertahun }}" readonly>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Pengeluaran Pertahun</label>
    <div class="col-md-4">
        <input type="text" name="pengeluaran_pertahun" class="number_format form-control"
            placeholder="Pengeluarn Pertahun .." value="{{ $pengeluaran_pertahun }}" readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Status tempat tinggal</label>
    <div class="col-md-4">
        <input type="text" name="status_tempat_tinggal" class="form-control" placeholder="Status Tempat Tinggal .."
            value="{{ $status_tempat_tinggal }}" readonly>
    </div>
</div>


<div class="form-group row">

    <label for="name" class="col-md-2 text-left">Jumlah Tanggungan</label>
    <div class="col-md-4">
        <input type="text" name="jumlah_tanggungan" class="form-control" placeholder="Jumlah Tanggungan .."
            value="{{ $jumlah_tanggungan }}" readonly>
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
            value="{{ $kelurahan_ktp }}" readonly>
    </div>
</div>

<div class="form-group row">

    <label for="name" class="col-md-2 text-left">Umur Peserta</label>
    <div class="col-md-4">
        <input type="number" name="umur_peserta" class="form-control" placeholder="umur_peserta .."
            value="{{ $umur_peserta }}" readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Status Perkawinan </label>
    <div class="col-md-4">
        <input type="text" name="status_peserta" class="form-control" placeholder="status_peserta .."
            value="{{ $status_peserta }}" readonly>
    </div>
</div>

<hr />
<h3 class="section-title">Data Tempat Tinggal
</h3>
<div class="form-group row">

    <label for="name" class="col-md-2 text-left">Rt / RW</label>
    <div class="col-md-4">
        <input type="text" name="rt_rw_ktp" class="form-control" placeholder="rt_rw_ktp .." value="{{ $rt_rw_ktp }}"
            readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Kelurahan Berdasarkan KTP</label>
    <div class="col-md-4">
        <input type="text" name="kelurahan_ktp" class="form-control" placeholder="kelurahan_ktp .."
            value="{{ $kelurahan_ktp }}" readonly>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Kecamatan</label>
    <div class="col-md-4">
        <input type="text" name="kecamatan_ktp" class="form-control" placeholder="kecamatan_ktp .."
            value="{{ $kecamatan_ktp }}" readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Kota / Kabupaten </label>
    <div class="col-md-4">
        <input type="text" name="kota_kabupaten_ktp" class="form-control" placeholder="kota_kabupaten_ktp .."
            value="{{ $kota_kabupaten_ktp }}" readonly>
    </div>

</div>
<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Provinsi</label>
    <div class="col-md-4">
        <input type="text" name="provinsi_ktp" class="form-control" placeholder="provinsi_ktp .."
            value="{{ $provinsi_ktp }}" readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Kode POS</label>
    <div class="col-md-4">
        <input type="text" name="kode_pos_ktp" class="form-control" placeholder="kode_pos_ktp .."
            value="{{ $kode_pos_ktp }}" readonly>
    </div>
</div>

<hr />
<h3 class="section-title">Data domisili</h3>
<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Alamat domisili</label>
    <div class="col-md-4">
        <input type="text" name="alamat_domisili" class="form-control" placeholder="alamat_domisili .."
            value="{{ $alamat_domisili }}" readonly>
    </div>
    <label for="name" class="col-md-2 text-left">RT / rw Domisili</label>
    <div class="col-md-4">
        <input type="text" name="rt_rw_domisili" class="form-control" placeholder="rt_rw_domisili .."
            value="{{ $rt_rw_domisili }}" readonly>
    </div>
</div>


<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Kelurahan Domisili</label>
    <div class="col-md-4">
        <input type="text" name="kelurahan_domisili" class="form-control" placeholder="kelurahan_domisili .."
            value="{{ $kelurahan_domisili }}" readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Kecamatan Domisili</label>
    <div class="col-md-4">
        <input type="text" name="kecamatan_domisili" class="form-control" placeholder="kecamatan_domisili .."
            value="{{ $kecamatan_domisili }}" readonly>
    </div>
</div>


<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Kota Kabupaten Domisli</label>
    <div class="col-md-4">
        <input type="text" name="kota_kabupaten_domisili" class="form-control" placeholder="kota_kabupaten_domisili .."
            value="{{ $kota_kabupaten_domisili }}" readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Provinsi Domisli</label>
    <div class="col-md-4">
        <input type="text" name="provinsi_domisili" class="form-control" placeholder="provinsi_domisili .."
            value="{{ $provinsi_domisili }}" readonly>
    </div>
</div>
<div class="form-group row">

    <label for="name" class="col-md-2 text-left">Kode Pos Domisili</label>
    <div class="col-md-4">
        <input type="text" name="kode_pos_domisili" class="form-control" placeholder="kode_pos_domisili .."
            value="{{ $kode_pos_domisili }}" readonly>
    </div>
    <label for="name" class="col-md-2 text-left">Jenis Penduduk</label>
    <div class="col-md-4">
        <input type="text" name="jenis_penduduk" class="form-control" placeholder="jenis_penduduk .."
            value="{{ $jenis_penduduk }}" readonly>
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


<script>
    $(function() {
        var idfilenya = "{{ $tmparameter_id }}";
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
