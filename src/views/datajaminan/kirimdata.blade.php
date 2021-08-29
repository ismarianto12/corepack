<section class="section">


    <h3 class="section-title">Konfirmasi Pengiriman Data </h3>
    <div class="alert alert-success">Data akan dikirim ke proses selanjutnya .</div>
    <form method="POST" id="konfirmasi">
        <input type="hidden" name="no_aplikasi" value="{{ $no_aplikasi }}">
        <button class="btn btn-primary"><i class="fa fa-send"></i>Kirim Data</button>
    </form>

</section>
<script>
    $(function() {
        $('#konfirmasi').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('dokumenjaminan.actionconfirm') }}',
                data: $(this).serialize(),
                method: 'post',
                chace: false,
                asynch: false,
                success: function(data) {
                    $('#datatable').DataTable().ajax.reload();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Data berhasil dikirim',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#formmodal').modal("hide");

                },
                error: function(data, error, JqXhr) {
                    console.log(data);
                    // Swal.fire({
                    //     icon: 'error',
                    //     title: 'Data gagal dikirim',
                    //     showConfirmButton: false,
                    // });
                }
            })

        });

    });
</script>
