@include('ismarianto::tmparameter.css')
<div class="row">
    <div class="col-12">
        <div class="container">
            <h4><i class="fas fa-check"></i>{{ _('Verifikasi Kelengkapan Data Dokumen Peserta') }}</h4>
            {!! Tmparamtertr::get_detailnasabah($no_aplikasi) !!}
        </div>
        <br />
        <br />
        <ul id="myTab" role="tablist"
            class="nav nav-tabs nav-pills flex-column flex-sm-row text-center bg-light border-0 rounded-nav">
            <li class="nav-item flex-sm-fill">
                <a id="uploaddocument-tab" data-toggle="tab" href="#uploaddocument" role="tab"
                    aria-controls="uploaddocument" aria-selected="true"
                    class="nav-link border-0 text-uppercase font-weight-bold active">Verifikasi
                    Document</a>
            </li>
            <li class="nav-item flex-sm-fill">
                <a id="kelengkapan-tab" data-toggle="tab" href="#kelengkapan" role="tab" aria-controls="kelengkapan"
                    aria-selected="false" class="nav-link border-0 text-uppercase font-weight-bold">Data
                    Peserta</a>
            </li>

            <li class="nav-item flex-sm-fill">
                <a id="kelengkapan_pmanfaat-tab" data-toggle="tab" href="#kelengkapan_pmanfaat" role="tab"
                    aria-controls="kelengkapan_pmanfaat" aria-selected="false"
                    class="nav-link border-0 text-uppercase font-weight-bold">Data
                    Penerima Manfaat</a>
            </li>
        </ul>
        <section class="section">

            {{-- @if ($p) --}}
            <div id="myTabContent" class="tab-content">
                <div id="uploaddocument" role="tabpanel" aria-labelledby="uploaddocument-tab"
                    class="tab-pane fade px-4 py-5 show active">
                    @include('ismarianto::verifikasi_kelengkapan.form_kelengkapan_part')
                </div>
                <div id="kelengkapan" role="tabpanel" aria-labelledby="kelengkapan-tab" class="tab-pane fade px-4 py-5">
                    @include('ismarianto::verifikasi_kelengkapan.detailnasabah')

                </div>
                <div id="kelengkapan_pmanfaat" role="tabpanel" aria-labelledby="kelengkapan_pmanfaat-tab"
                    class="tab-pane fade px-4 py-5">
                    @include('ismarianto::verifikasi_kelengkapan.detailnasabah_manfaat')

                </div>

            </div>
        </section>
    </div>
</div>
<!-- End rounded tabs -->
