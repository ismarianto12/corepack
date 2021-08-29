    <h1>Konfirmasi Pengiriman Data </h1>
    <div class="alert alert-success">Data akan dikirim ke proses selanjutnya .</div>
    <form method="POST">
        <button class="btn btn-primary"><i class="fa fa-send"></i>Kirim Data</button>
    </form>

    <script>
        $(function() {
            $('#konfirmasi').on('submit', function() {
                $.ajax({
                    url: '{{ route('uploaddankelengkapan.kofirmasi_kirim') }}'
                    data: $(this).serialize(),
                    chace: false,
                    asynch: false,
                    success: function(data) {

                    },
                    error: function(data, error, JqXhr) {
                        console.log(data);
                    }
                })

            });

        });
    </script>
