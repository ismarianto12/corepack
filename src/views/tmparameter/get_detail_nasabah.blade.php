<br /><br />

{{-- @dd($data) --}}
<div class="form-group row">
    <label for="kode_prouduk_induk" class="col-md-2 text-left">No . Ismarianto</label>
    <div class="col-md-4">
        : <b>{{ $data->no_aplikasi }}</b>
    </div>

    <label for="kode_prouduk_induk" class="col-md-2 text-left">Nama Peserta</label>
    <div class="col-md-4">
        : <b>{{ $data->nama_sesuai_ktp }}</b>
    </div>
</div>

<div class="form-group row">
    <label for="kode_prouduk_induk" class="col-md-2 text-left">Jenis Program</label>
    <div class="col-md-4">
        {{ $tmparametername }}
        <div class="detail_program"></div>
    </div>

    <label for="kode_prouduk_induk" class="col-md-2 text-left">Jenis Hadiah</label>
    <div class="col-md-4">
        : <b>{{ $data->jenis_hadiah }}</b>
    </div>
</div>

<div class="form-group row">
    <label for="kode_prouduk_induk" class="col-md-2 text-left">Nomor Rekening Induk (PAS)</label>
    <div class="col-md-4">
        : {{ $data->rekningpas ? $data->rekningpas : 'Kosong' }}
    </div>

    <label for="kode_prouduk_induk" class="col-md-2 text-left">Jumlah Penerima manfaat</label>
    <div class="col-md-4">
        : {{ $jmanfaat }} / Orang
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
    });
</script>
