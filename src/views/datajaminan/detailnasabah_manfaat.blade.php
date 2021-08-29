@php
$j = 1;

@endphp

{{-- @dd($pmanfaat_data) --}}
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
                    {{ $datas->nama }}
                </div>
            </div>
            <div class="form-group row">
                <label for="kode" class="col-md-2 text-left">Usia Penerima Manfaat</label>
                <div class="col-md-4">
                    {{ $datas->usia }}
                </div>
                <label for="kode" class="col-md-2 text-left">Hubungan</label>
                <div class="col-md-4">
                    {{ $datas->hubungan }}
                </div>
            </div>
            <div class="form-group row">
                <label for="kode" class="col-md-2 text-left">Pilihan Hadiah</label>

                <div class="col-md-4">
                    {{ $datas->pilihan_hadiah }}
                </div>
                <label for="kode" class="col-md-2 text-left">Nomor HP</label>

                <div class="col-md-4">
                    {{ $datas->no_hp }}
                </div>
            </div>
            <div class="form-group row">

                <label for="kode" class="col-md-2 text-left">Email</label>

                <div class="col-md-4">
                    {{ $datas->email }}
                </div>

                <label for="kode" class="col-md-2 text-left">Alamat</label>
                <div class="col-md-4">
                    {{ $datas->alamat }}
                </div>
            </div>
        </div>
    </div>
    @php
        $j++;
    @endphp

@endforeach
