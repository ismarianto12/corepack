<style type="text/css">
    .dropzone {
        border: 2px dashed #6777ef;
        min-height: 240px;
        text-align: center;
    }

</style>

<div class="container">
    <div class="jen">
        <h3 class="section-title">Pilih Jenis Upload</h3>
        <div class="form-group row">
            <label for="name" class="col-md-4 text-left">Document Upload</label>
            <div class="col-md-8">
                <select class="select2 form-control" name="jenis_" id="jenis_">
                    <option value="">Jenis Document Upload</option>
                    <option value="1">Peserta </option>
                    <option value="2">Penerima Manfaat</option>
                </select>
            </div>
        </div>

    </div>

    <div class="nasabah">
        <h3 class="section-title">Nasabah</h3>
        <div class="form-group row">
            <label for="name" class="col-md-4 text-left">Jenis Document Nasabah</label>
            <div class="col-md-8">
                <select class="select2 form-control" name="nama_file_peserta" id="nama_file_peserta">
                    <option value="">Pilih Jenis Document Nasabah</option>
                    @foreach ($fieldcolump as $pesertas)
                        <option value="{{ $pesertas->id }}">{{ $pesertas->nama_doc }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <br /> <br />

        <div id="table_file_nasabah"></div>

    </div>

    <div class="penerima_manfaat">
        <h3 class="section-title">Penerima Manfaat</h3>
        <div class="form-group row">
            <label for="name" class="col-md-4 text-left">Penerima manfaat</label>
            <div class="col-md-8">
                <select class="select2 form-control" name="nama_penerimamanfaat" id="nama_penerimamanfaat">
                    <option value=""></option>
                    @foreach ($getpenerimamanfaat as $pmanfaats)
                        <option value="{{ $pmanfaats->id }}">{{ $pmanfaats->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-md-4 text-left">Jenis Document Nasabah</label>
            <div class="col-md-8">
                <select class="select2 form-control" name="nama_file_penerimamanfaat" id="nama_file_penerimamanfaat">
                    @foreach ($fieldcolumpm as $fieldcolumpms)
                        <option value="{{ $fieldcolumpms->id }}">{{ $fieldcolumpms->nama_doc }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <br /> <br />

        <div id="table_file_penerima_manfaat"></div>
    </div>


    <div class="form-group row">
        <div class="col-md-12">
            <div id="file_upload" class="dropzone"></div>
        </div>
    </div>
</div>
