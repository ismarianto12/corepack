<style type="text/css">
    .dropzone {
        border: 2px dashed #6777ef;
        min-height: 240px;
        text-align: center;
    }

</style>

@php
if ($status == 'Peserta') {
    $ketsta = 'Peserta';
} elseif ($status == 'Pmanfaat') {
    $ketsta = 'Penerima manfaat';
}
@endphp

<section class="section">
    <div class="jen">
        <h3 class="section-title">Document : </h3>
        <p>Hadiah yang di pilih : {{ $hadiah }}</p>
        <div class="card-body">
            <div class="table-responsive">
                @if ($dparsed == 0)
                    <div class="alert alert-danger">Data Document untuk hadiah belum ada .

                    </div>
                @else

                    <form id="verifikasi" enctype="multipart/form-data">
                        <table class="table table-striped">
                            <tr>
                                <th>No. </th>
                                <th>Nama File</th>
                                <th>Detail</th>
                                <th>Status</th>
                                <th>Veryfied</th>
                                <th>Catatan</th>
                            </tr>
                            @php
                                $j = 0;
                            @endphp
                            @foreach ($dparsed as $documents)
                                @php
                                    $badge = $j % 2 ? 'success' : 'warning';
                                    $checked_cabang_l = $documents['otorisasi_cabang']['val'] == '1' ? 'checked' : '';
                                    $checked_cabang_d = $documents['otorisasi_cabang']['val'] == '0' ? 'checked' : '';
                                    $catatan_cabang = $documents['catatan_cabang']['val'];
                                    
                                    $checked_pusat_l = $documents['otorisasi_pusat']['val'] == '1' ? 'checked' : '';
                                    $checked_pusat_d = $documents['otorisasi_pusat']['val'] == '0' ? 'checked' : '';
                                    $catatan_pusat = $documents['catatan_pusat']['val'];
                                    
                                @endphp
                                {{-- @dd($checked_cabang); --}}

                                <tr>
                                    <th>{{ $j + 1 }}</th>
                                    <th>
                                        <div class="badge badge-{{ $badge }}">
                                            {{ $documents['nama_doc']['val'] }}
                                        </div>
                                    </th>
                                    <th>
                                        <a target="_blank" href="{{ $documents['nama_file']['val'] }}"
                                            class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    </th>
                                    <th>
                                        {{ $documents['status']['val'] }}
                                    </th>
                                    <th>
                                        <input type="hidden" name="jenis_peserta" value="{{ $status }}">

                                        @if ($level == 'manageroperation')
                                            <input type="hidden" name="nama_file[{{ $documents['nama_doc']['val'] }}]"
                                                value="{{ $documents['nama_doc']['val'] }}">

                                            <input type="radio" name="status[{{ $documents['id_par']['val'] }}]"
                                                value="0" {{ $checked_cabang_l }}>
                                            Sesuai
                                            <input type="radio" name="status[{{ $documents['id_par']['val'] }}]"
                                                value="1" {{ $checked_cabang_d }}>
                                            Tidak Sesuai
                                        @elseif($level == 'internalcontrol')
                                            <input type="hidden"
                                                name="nama_file[{{ $documents['nama_doc']['val'] }}]"
                                                value="{{ $documents['nama_doc']['val'] }}">

                                            <input type="radio" name="status[{{ $documents['id_par']['val'] }}]"
                                                value="0" {{ $checked_pusat_l }}>
                                            Sesuai
                                            <input type="radio" name="status[{{ $documents['id_par']['val'] }}]"
                                                value="1" {{ $checked_pusat_d }}>
                                            Tidak Sesuai

                                        @endif
                                    </th>
                                    <th>
                                        @if ($level == 'manageroperation')
                                            <textarea class="form-control"
                                                name="catatan[{{ $documents['id_par']['val'] }}]">{{ $catatan_cabang }}</textarea>
                                        @elseif($level == 'internalcontrol')
                                            <textarea class="form-control"
                                                name="catatan[{{ $documents['id_par']['val'] }}]">{{ $catatan_pusat }}</textarea>

                                        @endif


                                    </th>
                                </tr>
                                @php
                                    $j++;
                                @endphp
                            @endforeach
                        </table>
                        <hr />

                        <button type="submit" class="btn btn-primary" id="simpan"><i
                                class="fas fa-save"></i>Simpan</button>

                        <button type="reset" class="btn btn-warning" id="simpan"><i
                                class="fas fa-save"></i>Cancel</button>

            </div>
            </form>

            @endif
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function() {
        $('#verifikasi').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('otorisasi.savedata', $no_aplikasi) }}',
                method: "POST",
                chace: false,
                asynch: false,
                data: $(this).serialize(),
                success: function(data) {
                    if (data.status == 1) {
                        swal.fire('success', data.msg, 'success');
                    } else {
                        swal.fire('error', data.msg, 'erorr');
                    }
                },
                error: function(data, error, jqXHr) {
                    console.log(error, jqXHr);
                }
            })

        });
    });
</script>
