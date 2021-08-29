<style>
    select {
        font-family: 'FontAwesome', 'Second Font name'
    }

</style>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ _('Tambah data hubungan') }}</h4>
            </div>
            <form id="exampleValidation" method="POST" class="simpan">
                <div class="card-body p-0">
                    <div class="form-group row">

                        <label for="name" class="col-md-2 text-left"> Data Hubungan</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="" name="nama_hubungan" value="">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
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
            // alert('asa');
            $.ajax({
                url: "{{ route('trhububungan.store') }}",
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
                    //  $('.ket').html(
                    //      "<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Perahtian donk!</strong> " +
                    //      respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                }
            })
        });

        $('#level_akses_edit').select2();

        // $('#level_akses').select2({
        //     ajax: {
        //         type: 'GET',
        //         url: '{{ route('user.levelakses') }}',
        //         dataType: 'json',
        //         data: function(json) {
        //             return {
        //                 json: JSON.stringify(json),
        //                 delay: 0.3
        //             };
        //         },
        //         processResults: function(data) {
        //             return {
        //                 results: $.map(data, function(obj) {
        //                     return {
        //                         id: obj.id,
        //                         text: obj.levelname
        //                     };
        //                 })
        //             };
        //         }
        //     }
        // });
    });
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%'
        });
    });
</script>
