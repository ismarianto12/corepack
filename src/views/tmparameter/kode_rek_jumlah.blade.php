@for ($i = 1; $i <= $jumlah_data; $i++)
    <h3 class="section-title">Set Rekening Penerima Manfaaat Ke {{ $i }}</h3>

    <div class="form-group row">
        <label for="kode_produk_manfaat" class="col-md-2 text-left">Kode Produk Manfaat {{ $i }}</label>
        <div class="col-md-4">
            <input type="text" name="kode_prouduk_induk" class="form-control">
            <br />
            <select class="form-control">
                <option value="otomatis">Otomatis </option>
                <option value="manual">Kondisi </option>
            </select>
        </div>

        <label for="kode_produk_manfaat" class="col-md-2 text-left">Status Kepemilikan Rek {{ $i }}
        </label>
        <div class="col-md-4">
            <select class="form-control">
                <option value="">Pemilik Rekening</option>
                <option value="peserta">Peserta </option>
                <option value="p_manfaat">Penerima Manfaat </option>
            </select>
        </div>
    </div>
@endfor
