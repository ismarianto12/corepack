{{-- masanah was here --}}
<hr />
<h3 class="section-title">Pilihan Program
</h3>
<br />
<div class="form-group row">
    <input type="hidden" name="nasabah" value="nasabah">
    <label for="name" class="col-md-2 text-left">No Ismarianto</label>

    <div class="col-md-4">
        <input type="text" class="form-control" placeholder="no_aplikasi .." value="{{ $no_aplikasi }}" readonly>
    </div>
</div>

<div class="form-group row">
    <label for="tujuan_penggunaan" class="col-md-2 text=left">Program
        Tazam</label>
    <div class="col-md-4">
        {{ $tmparametername }}
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
        <input type="number" name="no_ktp" class="form-control" placeholder="Silahkan Entry No KTP"
            value="{{ $no_ktp }}" required>
    </div>
    <br />

    <label for="name" class="col-md-2 text-left">Nama Ibu Kandung
        KTP</label>
    <br />
    <div class="col-md-4">
        <input type="text" name="nama_ibu_kandung_ktp" class="form-control" value="{{ $nama_ibu_kandung_ktp }}"
            placeholder="Silahkan Entry Nama Ibu Kandung" required>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Nama Sesuai KTP</label>
    <div class="col-md-4">
        <input type="text" name="nama_sesuai_ktp" value="{{ $nama_sesuai_ktp }}" class="form-control"
            placeholder="Silahkan Entry Nama" required>
    </div>

    <label for="name" class="col-md-2 text-left">Tanggal Lahir
        KTP</label>
    <div class="col-md-4">
        <input type="date" value="{{ $tanggal_lahir_ktp }}" name="tanggal_lahir_ktp" id="tanggal_lahir_ktp"
            class="form-control" placeholder="Silahkan Entry Tanggal Lahir" onchange="umur()" required>
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Tempat Lahir</label>
    <div class="col-md-4">
        <textarea class="form-control" name="tempat_lahir_ktp" class="form-control"
            placeholder="Silahkan Entry Tempat Lahir" required>{{ $tempat_lahir_ktp }}</textarea>
    </div>
    <label for="name" class="col-md-2 text-left">Umur Peserta</label>
    <div class="col-md-4">
        <input type="text" name="umur_peserta" class="number_format form-control"
            placeholder="Umur Sesuai tanggal lahir otomatis" id="umur_peserta" value="{{ $umur_peserta }}" readonly>
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
    <label for="name" class="col-md-2 text-left">Pekerjaan Sesuai KTP</label>
    <div class="col-md-4">
        <select name="pekerjaan_ktp" class="form-control select2">
            <option value="Pegawai Negeri / BUMN">Pegawai Negeri / BUMN</option>
            <option value="Pegawai Swasta">Pegawai Swasta</option>
            <option value="Wiraswasta ">Wiraswasta </option>
            <option value="Pelajar /Mahasiswa">Pelajar /Mahasiswa</option>
            <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
            <option value="Lainya">Lainya</option>
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
        <input type="number" name="no_hp" value="{{ $no_hp }}" class="form-control"
            placeholder="Silahkan Entry No.Handphone" required>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Email</label>
    <div class="col-md-4">
        <input type="email" name="email" class="form-control" value="{{ $email }}"
            placeholder="Silahkan Entry Email" required>
    </div>
    <label for="name" class="col-md-2 text-left">Telephone</label>
    <div class="col-md-4">
        <input type="number" value="{{ $tlp_rumah }}" name=" tlp_rumah" class="form-control"
            placeholder="Silahkan Entry Telephone" required>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Penghasilan
        Perbulan</label>
    <div class="col-md-4">
        <input type="text" value="{{ $penghasilan_perbulan }}" name="penghasilan_perbulan"
            class="number_format form-control" placeholder="Silahkan Entry Penghasilan Perbulan" required>
    </div>
    <label for="name" class="col-md-2 text-left">Penghasilan Pertahun
    </label>
    <div class="col-md-4">
        <input type="text" placeholder="penghasilan_pertahun .." value="{{ $penghasilan_pertahun }}"
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
        <input type="text" name="pengeluaran_pertahun" value="{{ Tmparamtertr::curency($pengeluaran_pertahun) }}"
            class="number_format form-control" placeholder="Silahkan Entry Pengeluaran Pertahun" required>
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
        <input type="text" name="jumlah_tanggungan" value="{{ $jumlah_tanggungan }}" class="form-control"
            placeholder="Silahkan Entry Jumlah Tanggungan" required>
    </div>

</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Tujuan Penggunaan
        Data</label>
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
        <input type="text" name="rt_rw_ktp" value="{{ $rt_rw_ktp }}" class="form-control"
            placeholder="Silahkan Entry RT/RW KTP" required>
    </div>
    <label for="name" class="col-md-2 text-left">Kelurahan Berdasarkan
        KTP</label>
    <div class="col-md-4">
        <input type="text" name="kelurahan_ktp" value="{{ $kelurahan_ktp }}" class="form-control"
            placeholder="Silahkan Entry Kelurahan" required>
    </div>
</div>

<div class="form-group row">


    <label for="name" class="col-md-2 text-left">Provinsi</label>
    <div class="col-md-4">
        <input type="text" name="provinsi_ktp" value="{{ $provinsi_ktp }}" class="form-control"
            placeholder="Silahkan Entry Provinsi" required>
    </div>

    <label for="name" class="col-md-2 text-left">Kota / Kabupaten
    </label>
    <div class="col-md-4">
        <input type="text" name="kota_kabupaten_ktp" value="{{ $kota_kabupaten_ktp }}" class="form-control"
            placeholder="Silahkan Entry Kota / Kabupaten" required>
    </div>

</div>
<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Kecamatan</label>
    <div class="col-md-4">
        <input type="text" name="kecamatan_ktp" value="{{ $kecamatan_ktp }}" class="form-control"
            placeholder="Silahkan Entry Kecamatan" required>
    </div>


    <label for="name" class="col-md-2 text-left">Kota / Kabupaten
    </label>
    <div class="col-md-4">
        <input type="text" name="kota_kabupaten_ktp" value="{{ $kota_kabupaten_ktp }}" class="form-control"
            placeholder="Silahkan Entry Kota / Kabupaten" required>
    </div>

</div>

<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Kode POS</label>
    <div class="col-md-4">
        <input type="text" name="kode_pos_ktp" value="{{ $kode_pos_ktp }}" class="form-control"
            placeholder="Silahkan Entry Kode Pos" required>
    </div>

</div>

<hr />
<h3 class="section-title">Data domisili</h3>
<br />
<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Alamat domisili</label>
    <div class="col-md-4">
        <input type="text" name="alamat_domisili" value="{{ $alamat_domisili }}" class="form-control"
            placeholder="Silahkan Entry Alamat Domisili" required>
    </div>
    <label for="name" class="col-md-2 text-left">RT / RW
        Domisili</label>
    <div class="col-md-4">
        <input type="text" name="rt_rw_domisili" value="{{ $rt_rw_domisili }}" class="form-control"
            placeholder="Silahkan Entry RT/RW Domisili" required>
    </div>
</div>


<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Kelurahan
        Domisili</label>
    <div class="col-md-4">
        <input type="text" name="kelurahan_domisili" class="form-control" value="{{ $kelurahan_domisili }}"
            placeholder="Silahkan Entry Kelurahan Domisili" required>
    </div>
    <label for="name" class="col-md-2 text-left">Kecamatan
        Domisili</label>
    <div class="col-md-4">
        <input type="text" name="kecamatan_domisili" class="form-control" value="{{ $kecamatan_domisili }}"
            placeholder="Silahkan Entry Kecamatan Domisili" required>
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-md-2 text-left">Kota Kabupaten
        Domisli</label>
    <div class="col-md-4">
        <input type="text" name="kota_kabupaten_domisili" class="form-control" value="{{ $kota_kabupaten_domisili }}"
            placeholder="Silahkan Entry Kota / Kabupaten Domisili" required>
    </div>
    <label for="name" class="col-md-2 text-left">Provinsi
        Domisli</label>
    <div class="col-md-4">
        <input type="text" name="provinsi_domisili" value="{{ $provinsi_domisili }}" class="form-control"
            placeholder="Silahkan Entry Provinsi Domisili" required>
    </div>
</div>
<div class="form-group row">

    <label for="name" class="col-md-2 text-left">Kode Pos
        Domisili</label>
    <div class="col-md-4">
        <input type="text" name="kode_pos_domisili" value="{{ $kode_pos_domisili }}" class="form-control"
            placeholder="Silahkan Entry Kode Pos Domisili" required>
    </div>
    <label for="name" class="col-md-2 text-left">Jenis Penduduk</label>
    <div class="col-md-4">
        <input type="text" name="jenis_penduduk" value="{{ $jenis_penduduk }}" class="form-control"
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
<script>
    $(function() {
        $('.number_format').keyup(function(event) {
            // alert('fuck');
            if (event.which >= 37 && event.which <= 40) return;
            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });
    });

    var idfilenya = "{{ $tmparameter_id }}";
    var htmlnya = '<br /><a href="#" onclick="javascript:detailparameter(' + idfilenya +
        ')" class="btn btn-primary" datanya="' +
        idfilenya +
        '">Detail data progam</a>';
    $('.detail_program').html(htmlnya);


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
