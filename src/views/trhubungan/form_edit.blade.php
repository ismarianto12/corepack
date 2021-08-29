<style>
    select {
        font-family: 'FontAwesome', 'Second Font name'
    }

</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ _('Edit data hubungan') }}</h4>
            </div>
            <form id="exampleValidation" method="POST" class="simpan">
                <div class="card-body p-0">
                    <div class="form-group row">
                        <label for="name" class="col-md-2 text-left"> Data Hubungan</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="" name="nama_hubungan"
                                value="{{ $nama_hubungan }}">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit"><i class="fas fa-save"></i>Simpan Data</button>
                    <button class="btn btn-secondary" type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('.simpan').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('trhububungan.update',  $id)",
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
                    });
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
                }
            })
        });

    });
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%'
        });
    });
</script>
