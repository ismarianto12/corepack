<section class="section">

    @for ($a = 1; $a <= $passed; $a++)
        @php
            $class = $a % 2 ? 'class="hero bg-primary text-white"' : '';
        @endphp
        <hr />
        <h2 class="section-title">Data Penerima Manfaat Ke - {{ $a }}</h2>
        <br />
        <div class="form-group row">
            <input required type="hidden" value="{{ $passed }}" name="penerima_manfaat">
            <label for="name" class="col-md-2 text=left">Nama Penerima Manfaat
                {{ $a }}</label>
            <div class="col-md-4">
                <input required class="form-control" name="nama_penerima_manfaat_{{ $a }}"
                    id="nama_penerima_manfaat_{{ $a }}">
                <div class="invalid-feedback">
                    Silakan entri data Nama Penerima Manfaat
                </div>
            </div>

            <label for="usia" class="col-md-2 text=left">Usia Penerima manfaat
                {{ $a }}</label>
            <div class="col-md-4">
                <input required type="text" max="2" name="usia_penerima_manfaat_{{ $a }}"
                    class="number_format form-control" id="usia_penerima_manfaat_{{ $a }}" readonly>
                <div class="invalid-feedback">
                    Maksimal . 2 Digit
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-md-2 text-left">Tanggal Lahir</label>
            <div class="col-md-4">
                <input type="date" name="tgl_lahir_{{ $a }}" id="tgl_lahir_{{ $a }}"
                    class="form-control" placeholder="Silahkan Entry Tanggal Lahir"
                    onchange="umur{{ $a }}()" required>
            </div>
        </div>

        <div class="form-group row">

            <label for="hubungan" class="col-md-2 text=left">Hubungan </label>
            <div class="col-md-4">
                <select class="form-control" name="hubungan_penerima_manfaat_{{ $a }}"
                    id="hubungan_penerima_manfaat_{{ $a }}" required>
                    <option value=""></option>
                    @foreach ($hubungan as $hubungans)
                        <option value="{{ $hubungans->id }}">{{ $hubungans->nama_hubungan }}</option>
                    @endforeach
                </select>


                <div class="invalid-feedback">
                    Silakan entri data Hubungan
                </div>
            </div>

            <label for="pilihan_hadiah" class="col-md-2 text=left">Pilihan Hadiah</label>
            <div class="col-md-4">
                <select class="form-control" name="pilihan_hadiah_penerima_manfaat_{{ $a }}" required>
                    <option value=""></option>
                    @foreach ($tmhadiah as $tmhadiahs)
                        <option value="{{ $tmhadiahs->id }}">
                            {{ $tmhadiahs->jenis_hadiah }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Silakan entri data Pilihan Hadiah
                </div>
            </div>
        </div>

        <div class="form-group row">

            <label for="no_hp" class="col-md-2 text=left">No Hp </label>
            <div class="col-md-4">
                <input required class="form-control" name="no_hp_penerima_manfaat_{{ $a }}" id="no_hp"
                    type="number">
                <div class="invalid-feedback">
                    Silakan entri data No Handphone
                </div>
            </div>

            <label for="email" class="col-md-2 text=left">Email</label>
            <div class="col-md-4">
                <input required type="email" name="email_penerima_manfaat_{{ $a }}" class="form-control"
                    id="email">
                <div class="invalid-feedback">
                    Silakan entri data Email
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="alamat" class="col-md-2 text=left">Alamat</label>
            <div class="col-md-4">
                <textarea class="form-control" name="alamat_penerima_manfaat_{{ $a }}" id="alamat" cols="12"
                    rows="20" required></textarea>
                <div class="invalid-feedback">
                    Silakan entri data Alamat
                </div>
            </div>
        </div>


        <script>
            // function copy field 
            $(function() {
                // it self return field must fill 
                $('#hubungan_penerima_manfaat_{{ $a }}').on('change', function(data) {
                    value = $(this).val();


                    // def name 
                    var nama_sesuai_ktp = $('input[name="nama_sesuai_ktp"]').val();
                    var umur_peserta = $('input[name="umur_peserta"]').val();
                    var tanggal_lahir_ktp = $('input[name="tanggal_lahir_ktp"]').val();
                    var hadiah = $('input[name="hadiah"]').val();
                    var no_hp = $('input[name="no_hp"]').val();
                    var email = $('input[name="email"]').val();
                    var alamat_domisili = $('input[name="alamat_domisili"]').val();
                    console.log(value)

                    if (value == 1) {
                        $('input[name="nama_penerima_manfaat_{{ $a }}"]').val(nama_sesuai_ktp);
                        $('input[name="usia_penerima_manfaat_{{ $a }}"]').val(umur_peserta);
                        $('input[name="tgl_lahir_{{ $a }}"]').val(tanggal_lahir_ktp);
                        $('input[name="hubungan_penerima_manfaat_{{ $a }}"]').val();
                        $('input[name="tmhadiah_id_{{ $a }}"]').val(hadiah);
                        $('input[name="no_hp_penerima_manfaat_{{ $a }}"]').val(no_hp);
                        $('input[name="email_penerima_manfaat_{{ $a }}"]').val(email);
                        $('input[name="alamat_penerima_manfaat_{{ $a }}"]').val(alamat_domisili);
                    }
                });
            });



            function umur() {
                var dateString = document.getElementById('tgl_lahir_{{ $a }}').value;
                var today = new Date();
                var birthDate = new Date(dateString);
                var age = today.getFullYear() - birthDate.getFullYear();
                var m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                var theBday = document.getElementById('usia_penerima_manfaat_{{ $a }}');
                theBday.value = age;
            }
        </script>

    @endfor
</section>
