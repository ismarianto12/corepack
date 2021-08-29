<section class="section">
    {{-- @dd($data_penerima_manfaat[1]['no_aplikasi']) --}}

    @if ($passed == '')

        @php
        $j = $jumlah_penerima_manfaat; @endphp
    @else

        @php
            $j = $passed;
        @endphp

    @endif
    @for ($a = 1; $a <= $j; $a++)
        @php
            $basad = $a - 1;
            $class = $a % 2 ? 'class="hero bg-primary text-white"' : '';
        @endphp
        @dd($data_penerima_manfaat);
        <hr />
        <h2 class="section-title">Data Penerima Manfaat Ke - {{ $a }}</h2>
        @if ($data_penerima_manfaat[$basad]['overide_status'] != 0)
            @if ($data_penerima_manfaat[$basad]['overide_status'] == 2)
                <hr />
                <div class="alert alert-danger">Catatan revisi OM :
                    {{ $data_penerima_manfaat[$basad]['catatan_cabang'] }}
                    <br />
                    <h4>Catatan overide </h4>
                    @foreach (json_decode($data_penerima_manfaat[$basad]['keterangan_overide']) as $datas => $val)
                        <p> {{ $val }} </p>
                    @endforeach
                </div>
            @endif
        @endif
        <div class="form-group row">
            <input type="hidden" value="{{ $j }}" name="penerima_manfaat">
            <label for="name" class="col-md-2 text=left">Nama Penerima Manfaat
                {{ $a }}</label>
            <div class="col-md-4">
                <input class="form-control" name="nama_penerima_manfaat_{{ $a }}"
                    value="{{ $data_penerima_manfaat[$basad]['nama'] }}" id="name">
                <div class="invalid-feedback">
                    Please Entry Nama Penerima Manfaat
                </div>
            </div>

            <label for="usia" class="col-md-2 text=left">Usia Penerima manfaat
                {{ $a }}</label>
            <div class="col-md-4">
                <input type="text" name="usia_penerima_manfaat_{{ $a }}"
                    value="{{ $data_penerima_manfaat[$basad]['usia'] }}" class="form-control" id="usia">
                <div class="invalid-feedback">
                    Please Entry Usia Penerima Manfaat
                </div>
            </div>
        </div>

        <div class="form-group row">

            <label for="hubungan" class="col-md-2 text=left">Hubungan </label>
            <div class="col-md-4">
                <input class="form-control" name="hubungan_penerima_manfaat_{{ $a }}"
                    value="{{ $data_penerima_manfaat[$basad]['hubungan'] }}" id="hubungan_penerima_manfaat">
                <div class="invalid-feedback">
                    Please Entry Hubungan
                </div>
            </div>

            <label for="pilihan_hadiah" class="col-md-2 text=left">Pilihan Hadiah</label>
            <div class="col-md-4">
                <input type="text" name="pilihan_hadiah_penerima_manfaat_{{ $a }}" class="form-control"
                    id="pilihan_hadiah_penerima_manfaat"
                    value="{{ $data_penerima_manfaat[$basad]['pilihan_hadiah'] }}">
                <div class="invalid-feedback">
                    Please Entry Pilihan Hadiah
                </div>
            </div>
        </div>

        <div class="form-group row">

            <label for="no_hp" class="col-md-2 text=left">No Hp </label>
            <div class="col-md-4">
                <input class="form-control" name="no_hp_penerima_manfaat_{{ $a }}" id="no_hp"
                    value="{{ $data_penerima_manfaat[$basad]['no_hp'] }}">
                <div class="invalid-feedback">
                    Please Entry No Handphone
                </div>
            </div>

            <label for="email" class="col-md-2 text=left">Email</label>
            <div class="col-md-4">
                <input type="text" name="email_penerima_manfaat_{{ $a }}" class="form-control" id="email"
                    value="{{ $data_penerima_manfaat[$basad]['email'] }}">
                <div class="invalid-feedback">
                    Please Entry Email
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="alamat" class="col-md-2 text=left">Alamat</label>
            <div class="col-md-4">
                <input class="form-control" name="alamat_penerima_manfaat_{{ $a }}" id="alamat"
                    value="{{ $data_penerima_manfaat[$basad]['alamat'] }}">
                <div class="invalid-feedback">
                    Please Entry Alamat
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="catatan" class="col-md-2 text=left">Catatan Overide</label>
            <div class="col-md-4">
                <textarea class="form-control" name="catatan_pmanfaat_{{ $a }}"></textarea>
            </div>
            <div class="col-md-4">
                <br />
                @if (Tmparamtertr::session('role') == 'manageroperation')
                    <select class="form-control" name="status" id="status">
                        @foreach (Tmparamtertr::status_approve() as $val => $ket)
                            @php
                                $selected = $status_approve == $val ? 'selected' : '';
                            @endphp
                            @if ($val != 3 && $val != 4 && $val != 5))
                                <option value="{{ $val }}" {{ $selected }}>
                                    {{ $ket }}</option>
                            @endif
                        @endforeach
                    </select>
                @elseif(Tmparamtertr::session('role') == 'internalcontrol')
                    <select class="form-control" name="status" id="status">
                        @foreach (Tmparamtertr::status_approve() as $val => $ket)
                            @if ($val != 1 && $val != 2)
                                @php
                                    $cselected = $status_approve == $val ? 'selected' : '';
                                @endphp
                                <option value="{{ $val }}" {{ $cselected }}>
                                    {{ $ket }}</option>
                            @endif
                        @endforeach
                    </select>
                @endif
            </div>
        </div>

    @endfor
</section>
