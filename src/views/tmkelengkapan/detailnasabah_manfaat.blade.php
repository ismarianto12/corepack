@php
$j = 1;

@endphp

@if ($pmanfaat_data->count() > 0)

    @foreach ($pmanfaat_data as $datas)
        {{-- @dd($datas) --}}
        <h2 class="section-title"><i class="fas fa-user"></i> Manfaat Ke - {{ $j }}</h2>

        <div class="row">
            <div class="col-12">
                <div class="form-group row">
                    <input type="hidden" name="idnya_{{ $datas->id }}" value="{{ $datas->id }}">
                    <label for="kode" class="col-md-2 text-left">Nomor Aplikasi</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" value="{{ $datas->no_aplikasi }}" readonly>
                    </div>
                    <label for="kode" class="col-md-2 text-left">Nama</label>

                    <div class="col-md-4">
                        <input type="text" name="nama_{{ $j }}" class="form-control"
                            value="{{ $datas->nama }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kode" class="col-md-2 text-left">Usia Penerima Manfaat</label>
                    <div class="col-md-4">
                        <input type="text" name="usia_{{ $j }}" class="form-control"
                            value="{{ $datas->usia }}">
                    </div>
                    <label for="kode" class="col-md-2 text-left">Hubungan</label>
                    <div class="col-md-4">
                        <input type="text" name="hubungan_{{ $j }}" class="form-control"
                            value="{{ $datas->hubungan }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kode" class="col-md-2 text-left">Pilihan Hadiah</label>

                    <div class="col-md-4">
                        {{-- <input type="text" name="pilihan_hadiah_{{ $j }}" class="form-control"
                        value="{{ $datas->pilihan_hadiah }}"> --}}
                        <select name="tmhadiah_id_{{ $j }}" class="form-control">
                            @foreach ($tmhadiah as $tmhadiahs)
                                @php
                                    $selected = $tmhadiahs->id == $datas->tmhadiah_id ? 'selected' : '';
                                @endphp
                                <option value="{{ $tmhadiahs->id }}" {{ $selected }}>
                                    {{ $tmhadiahs->jenis_hadiah }}</option>
                            @endforeach

                        </select>

                    </div>
                    <label for="kode" class="col-md-2 text-left">Nomor HP</label>

                    <div class="col-md-4">
                        <input type="text" name="no_hp_{{ $j }}" class="form-control"
                            value="{{ $datas->no_hp }}">
                    </div>
                </div>
                <div class="form-group row">

                    <label for="kode" class="col-md-2 text-left">Email</label>

                    <div class="col-md-4">
                        <input type="text" name="email_{{ $j }}" class="form-control"
                            value="{{ $datas->email }}">
                    </div>

                    <label for="kode" class="col-md-2 text-left">Alamat</label>
                    <div class="col-md-4">
                        <textarea class="form-control" cols="5" rows="18"
                            name="alamat_{{ $j }}">{{ $datas->alamat }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        @php
            $j++;
        @endphp

    @endforeach

@else
    <div class="alert alert-danger">Tidak ada penerima manfaat</div>
@endif
