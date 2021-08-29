<style>
    select {
        font-family: 'FontAwesome', 'Second Font name'
    }

</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ _('Setting Parameter biaya ') }}</h4>
            </div>
            <div id="ket"></div>
            <form id="exampleValidation" method="POST" class="simpan">
                <div class="form-group row">
                    <label class="col-md-2" name="tmparameter_id">Paramater Program</label>
                    <div class="col-md-4">
                        <select class="form-control" name="tmparameter_id">
                            @foreach ($tmparameter as $parameters)
                                <option value="{{ $parameters->id }} ">{{ $parameters->kode_prog }} -
                                    [{{ $parameters->nama_prog }}]</option>

                            @endforeach
                        </select>
                    </div>
                    <label class="col-md-2" name="nominal">Nominal</label>
                    <div class="col-md-4">
                        <input type="text" name="nominal" class="number_format form-control">
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-md-2" name="dari_bulan">Dari bulan</label>
                    <div class="col-md-4">
                        <select class="form-control" name="dari_bulan">
                            @for ($d = 1; $d <= 120; $d++)
                                <option value="{{ $d }}">Bulan Ke - {{ $d }}</option>
                            @endfor
                        </select>
                    </div>
                    <label class="col-md-2" name="ke_bulan">Ke Bulan</label>
                    <div class="col-md-4">
                        <select class="form-control" name="ke_bulan">
                            @for ($d = 1; $d <= 120; $d++)
                                <option value="{{ $d }}">Bulan Ke - {{ $d }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary btn-md" type="submit"><i class="fas fa-save"></i> Simpan
                        data</button>
                    <button class="btn btn-secondary btn-md" type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            // alert('asa');
            $.ajax({
                url: "{{ route('trtablebiaya.store') }}",
                method: "POST",
                data: $(this).serialize(),
                chace: false,
                async: false,
                success: function(data) {
                    $('#datatable').DataTable().ajax.reload();
                    $('#formmodal').modal('hide');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Data berhasil di simpan',
                        showConfirmButton: false,
                        timer: 1500
                    })
                },
                error: function(data) {
                    var div = $('#container');
                    setInterval(function() {
                        var pos = div.scrollTop();
                        div.scrollTop(pos + 2);
                    }, 10)
                    err = '';
                    respon = data.responseJSON;
                    $.each(respon.errors, function(index, value) {
                        err += "<li>" + value + "</li>";
                    });
                    $('.ket').html(
                        "<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Perahtian donk!</strong> " +
                        respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                }
            })
        });

        $('#level_akses_edit').select2();

    });
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%'
        });
    });
</script>
