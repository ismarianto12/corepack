<section class="section">

    @for ($a = 1; $a <= $passed; $a++)
        @php
            $class = $a % 2 ? 'class="hero bg-primary text-white"' : '';
        @endphp
        <hr />
        <h2 class="section-title">Data Penerima Manfaat Ke - {{ $a }}</h2>

        <div class="form-group row">
            <input type="hidden" value="{{ $passed }}" name="penerima_manfaat">
            <label for="name" class="col-md-2 text=left">Nama Penerima Manfaat
                {{ $a }}</label>
            <div class="col-md-4">
                <input class="form-control" name="nama_penerima_manfaat_{{ $a }}" id="name">
                <div class="invalid-feedback">
                    Please Entry Nama Penerima Manfaat
                </div>
            </div>

            <label for="usia" class="col-md-2 text=left">Usia Penerima manfaat
                {{ $a }}</label>
            <div class="col-md-4">
                <input type="text" name="usia_penerima_manfaat_{{ $a }}" class="form-control" id="usia">
                <div class="invalid-feedback">
                    Please Entry Usia Penerima Manfaat
                </div>
            </div>
        </div>

        <div class="form-group row">

            <label for="hubungan" class="col-md-2 text=left">Hubungan </label>
            <div class="col-md-4">
                <input class="form-control" name="hubungan_penerima_manfaat_{{ $a }}"
                    id="hubungan_penerima_manfaat">
                <div class="invalid-feedback">
                    Please Entry Hubungan
                </div>
            </div>

            <label for="pilihan_hadiah" class="col-md-2 text=left">Pilihan Hadiah</label>
            <div class="col-md-4">
                <input type="text" name="pilihan_hadiah_penerima_manfaat_{{ $a }}" class="form-control"
                    id="pilihan_hadiah_penerima_manfaat">
                <div class="invalid-feedback">
                    Please Entry Pilihan Hadiah
                </div>
            </div>
        </div>

        <div class="form-group row">

            <label for="no_hp" class="col-md-2 text=left">No Hp </label>
            <div class="col-md-4">
                <input class="form-control" name="no_hp_penerima_manfaat_{{ $a }}" id="no_hp">
                <div class="invalid-feedback">
                    Please Entry No Handphone
                </div>
            </div>

            <label for="email" class="col-md-2 text=left">Email</label>
            <div class="col-md-4">
                <input type="text" name="email_penerima_manfaat_{{ $a }}" class="form-control" id="email">
                <div class="invalid-feedback">
                    Please Entry Email
                </div>
            </div>
        </div>

        <div class="form-group row">

            <label for="alamat" class="col-md-2 text=left">Alamat</label>
            <div class="col-md-4">
                <input class="form-control" name="alamat_penerima_manfaat_{{ $a }}" id="alamat">
                <div class="invalid-feedback">
                    Please Entry Alamat
                </div>
            </div>
        </div>
    @endfor
</section>
