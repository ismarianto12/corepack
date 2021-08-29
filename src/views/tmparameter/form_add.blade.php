@include('tazamcore::tmparameter.css')

<div class="row">
    <div class="col-12">

        <h4>{{ _('Tambah Parameter program') }}</h4>
        <hr />
        <br />
        <!-- Rounded tabs -->
        <ul id="myTab" role="tablist"
            class="nav nav-tabs nav-pills flex-column flex-sm-row text-center bg-light border-0 rounded-nav">
            <li class="nav-item flex-sm-fill">
                <a id="program-tab" data-toggle="tab" href="#program" role="tab" aria-controls="program"
                    aria-selected="true" class="nav-link border-0 text-uppercase font-weight-bold active">Program</a>
            </li>
            <li class="nav-item flex-sm-fill">
                <a id="produk-tab" data-toggle="tab" href="#produk" role="tab" aria-controls="produk"
                    aria-selected="false" class="nav-link border-0 text-uppercase font-weight-bold">Produk
                    Terkait</a>
            </li>
            <li class="nav-item flex-sm-fill">
                <a id="rekening -tab" data-toggle="tab" href="#rekening" role="tab" aria-controls="rekening"
                    aria-selected="false" class="nav-link border-0 text-uppercase font-weight-bold">
                    Rekening</a>
            </li>

            <li class="nav-item flex-sm-fill">
                <a id="jenisd-tab" data-toggle="tab" href="#jenisd" role="tab" aria-controls="jenisd"
                    aria-selected="false" class="nav-link border-0 text-uppercase font-weight-bold">Jenis Hadiah
                    & Document </a>
            </li>

            <li class="nav-item flex-sm-fill">
                <a id="fee-tab" data-toggle="tab" href="#fee" role="tab" aria-controls="fee" aria-selected="false"
                    class="nav-link border-0 text-uppercase font-weight-bold">Fee dan Insentif </a>
            </li>
        </ul>

        <section class="section">
            @include('tazamcore::tmparameter.add_form_part')
        </section>
    </div>
    <!-- End rounded tabs -->
</div>

</div>

<script type="text/javascript">
    $(function() {

        // get table depent wel

        $('.number_format').keyup(function(event) {
            // alert('fuck');
            if (event.which >= 37 && event.which <= 40) return;
            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });

        $('.simpan').on('submit', function(event) {
            event.preventDefault();

            $('#btnsimpan').removeClass('btn btn-primary');
            $('#btnsimpan').addClass('btn disabled btn-primary btn-progress');

            if ($(this)[0].checkValidity() === false) {

                $('#btnsimpan').removeClass('btn disabled btn-primary btn-progress');
                $('#btnsimpan').addClass('btn btn-primary');
                Swal.fire(
                    'error',
                    'Ada kesalahan silahkan lengkapi form yang kosong',
                    'error'
                );
                event.preventDefault();
                event.stopPropagation();
            } else {
                $.ajax({
                    url: "{{ route('parameter.store') }}",
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
                            title: 'Datas berhasil di simpan',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    error: function(response) {}
                })
            }
        });
        $('#reset').on('click', function(event) {
            $('.simpan')[0].reset();
            $('#simpan').removeClass('btn disabled btn-primary btn-progress');
            $('#simpan').addClass('btn btn-primary');


        });
    });
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            width: '100%'
        });
    });

    // aad function if callable to table document if that depent to 
</script>