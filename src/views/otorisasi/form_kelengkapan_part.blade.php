<section class="section" style="overflow: hidden">
    <div class="jen">
        <h4>{{ _('Upload Document dan kelengkapan data peserta ') }}</h4>

        <h3 class="section-title">
            Document :
        </h3>
        <p>Hadiah yang di pilih : {{ $hadiah }}</p>
        <div class="card-body">

            @if ($dpeserta == 0)
                <div class="alert alert-danger">Data Document untuk hadiah belum ada .
                </div>
            @else

                {!! Tmparamtertr::get_detailnasabah($no_aplikasi) !!}
                <form id="verifikasi" class="form-horizontal">
                    <table class="table table-bordered">
                        <tr>
                            <th>No. </th>
                            <th>Nama File</th>
                            <th>Detail</th>
                            <th>Status</th>
                            <th>Veryfied</th>
                            <th>Ket</th>
                        </tr>
                        @php
                            $j = 0;
                        @endphp



                        @foreach ($dpeserta as $documents)
                            @php
                                $badge = $j % 2 ? 'success' : 'warning';
                                $checked_cabang_l = $documents['otorisasi_cabang']['val'] == '1' ? 'checked' : '';
                                $checked_cabang_d = $documents['otorisasi_cabang']['val'] == '0' ? 'checked' : '';
                                $catatan_cabang = $documents['catatan_cabang']['val'];
                                
                                $checked_pusat_l = $documents['otorisasi_pusat']['val'] == '1' ? 'checked' : '';
                                $checked_pusat_d = $documents['otorisasi_pusat']['val'] == '0' ? 'checked' : '';
                                $catatan_pusat = $documents['catatan_pusat']['val'];
                                
                            @endphp

                            {{-- @dd($documents['otorisasi_cabang']['val']) --}}
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
                                    <input type="hidden" name="jenis_peserta" value="peserta">
                                    @if ($level == 'manageroperation')
                                        <input type="hidden"
                                            name="nama_file[{{ $documents['nama_doc']['val'] . $j }}]"
                                            value="{{ $documents['nama_doc']['val'] }}">

                                        <input type="radio" required
                                            name="status[{{ $documents['id_par']['val'] . $j }}]" value="1"
                                            {{ $checked_cabang_l }}>
                                        Sesuai
                                        <input type="radio" required
                                            name="status[{{ $documents['id_par']['val'] . $j }}]" value="0"
                                            {{ $checked_cabang_d }}>
                                        Tidak Sesuai
                                    @elseif($level == 'internalcontrol')
                                        <input type="hidden"
                                            name="nama_file[{{ $documents['nama_doc']['val'] . $j }}]"
                                            value="{{ $documents['nama_doc']['val'] }}">

                                        <input type="radio" required
                                            name="status[{{ $documents['id_par']['val'] . $j }}]" value="1"
                                            {{ $checked_pusat_l }}>
                                        Sesuai
                                        <input type="radio" required
                                            name="status[{{ $documents['id_par']['val'] . $j }}]" value="0"
                                            {{ $checked_pusat_d }}>
                                        Tidak Sesuai

                                    @endif
                                </th>
                                <th>
                                    @if ($level == 'manageroperation')
                                        <textarea class="form-control"
                                            name="catatan_{{ $j }}">{{ $catatan_cabang }}</textarea>
                                    @elseif($level == 'internalcontrol')
                                        <textarea class="form-control"
                                            name="catatan_{{ $j }}">{{ $catatan_pusat }}</textarea>

                                    @endif
                                </th>
                            </tr>
                            @php
                                $j++;
                            @endphp
                        @endforeach
                    </table>
                    <hr />

                    @php
                        $n = 1;
                    @endphp

                    @foreach ($getpenerimamanfaat as $pmanfaats)


                        <h3 class="section-title"> Penerima manfaat {{ $n }}</h3>
                        <table class="table">
                            <tr>
                                <td>Nomor Aplikasi</td>
                                <td>
                                    {{ $pmanfaats->no_aplikasi }}
                                </td>

                                <td>Nama</td>
                                <td>
                                    {{ $pmanfaats->nama }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Usia Penerima Manfaat</td>
                                <td>
                                    {{ $pmanfaats->usia }}
                                </td>

                                <td>Hubungan</td>
                                <td>
                                    {{ $pmanfaats->hubungan }}
                                </td>
                            </tr>
                            <tr>
                                <td>Pilihan Hadiah</td>
                                <td>
                                    {{ $pmanfaats->jenis_hadiah }}
                                </td>

                                <td>Nomor HP</td>
                                <td>
                                    {{ $pmanfaats->no_hp }}
                                </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>
                                    {{ $pmanfaats->email }}
                                </td>

                                <td>Alamat</td>
                                <td>
                                    {{ $pmanfaats->alamat }}
                                </td>
                            </tr>
                        </table>

                        @php
                            $pmnafaatid = $pmanfaats->pmnanfaat_id;
                        @endphp

                        <table class="table table-bordered">
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
                            {{-- document penerima manfaat --}}
                            @foreach ($dmanfaat as $dmanfaats)
                                @php
                                    $badge = $j + (1 % 2) ? 'success' : 'warning';
                                    $fileid = $dmanfaats['id_par']['val'];
                                    
                                    //  d sama dengan dtolak
                                    //  1 sama dengan diterima oleh sebelumnya
                                    
                                    $checked_cabang_l = $dmanfaats['otorisasi_cabang']['val'] == '1' ? 'checked' : '';
                                    $checked_cabang_d = $dmanfaats['otorisasi_cabang']['val'] == '0' ? 'checked' : '';
                                    $catatan_cabang = $dmanfaats['catatan_cabang']['val'];
                                    
                                    $checked_pusat_l = $dmanfaats['otorisasi_pusat']['val'] == '1' ? 'checked' : '';
                                    $checked_pusat_d = $dmanfaats['otorisasi_pusat']['val'] == '0' ? 'checked' : '';
                                    $catatan_pusat = $dmanfaats['catatan_pusat']['val'];
                                    
                                @endphp

                                <tr>
                                    <th>{{ $j + 1 }}</th>
                                    <th>
                                        <tt>
                                            {{ $dmanfaats['nama_doc']['val'] }}
                                        </tt>
                                    </th>
                                    <th>
                                        <a target="_blank" href="{{ $dmanfaats['nama_file']['val'] }}"
                                            class="btn btn-info btn-sm" target="_blank"><i class="fas fa-file"></i></a>
                                    </th>
                                    <th>
                                        {{ $dmanfaats['status']['val'] }}
                                    </th>
                                    <th>
                                        <input type="hidden" name="jenis_peserta" value="pmanfaat">

                                        @if ($level == 'manageroperation')
                                            <input type="hidden"
                                                name="nama_file{{ $n . $pmnafaatid }}[{{ $dmanfaats['nama_doc']['val'] }}]"
                                                value="{{ $dmanfaats['nama_doc']['val'] }}">

                                            <input type="radio" required
                                                name="status_pmanfaat{{ $n . $pmnafaatid }}[{{ $dmanfaats['id_par']['val'] }}]"
                                                value="1" {{ $checked_cabang_l }}>
                                            Sesuai
                                            <input type="radio" required
                                                name="status_pmanfaat{{ $n . $pmnafaatid }}[{{ $dmanfaats['id_par']['val'] }}]"
                                                value="0" {{ $checked_cabang_d }}>
                                            Tidak Sesuai
                                        @elseif($level == 'internalcontrol')
                                            <input type="hidden"
                                                name="nama_file{{ $n . $pmnafaatid }}[{{ $dmanfaats['nama_doc']['val'] }}]"
                                                value="{{ $dmanfaats['nama_doc']['val'] }}">

                                            <input type="radio" required
                                                name="status_pmanfaat{{ $n . $pmnafaatid }}[{{ $dmanfaats['id_par']['val'] }}]"
                                                value="1" {{ $checked_cabang_l }}>
                                            Sesuai
                                            <input type="radio" required
                                                name="status_pmanfaat{{ $n . $pmnafaatid }}[{{ $dmanfaats['id_par']['val'] }}]"
                                                value="0" {{ $checked_pusat_d }}>
                                            Tidak Sesuai

                                        @endif
                                    </th>
                                    <th>
                                        @if ($level == 'manageroperation')
                                            <textarea class="form-control"
                                                name="catatan_pmanfaat{{ $n . $pmnafaatid }}">{{ $catatan_cabang }}</textarea>
                                        @elseif($level == 'internalcontrol')
                                            <textarea class="form-control"
                                                name="catatan_pmanfaat{{ $n . $pmnafaatid }}">{{ $catatan_pusat }}</textarea>

                                        @endif

                                    </th>
                                </tr>
                                @php
                                    $j++;
                                @endphp
                            @endforeach

                        </table>


                        @php
                            $n++;
                        @endphp
                    @endforeach

                    <table class="table table-bordered">
                        <tr>
                            <td colspan="3">Status Otorisasi</td>
                            <td colspan="3">
                                @if (Tmparamtertr::session('role') == 'manageroperation')
                                    <select class="form-control" required name="status_approve" id="jenis_hadiah"
                                        required>
                                        @foreach (Tmparamtertr::status_approve() as $val => $ket)
                                            @php
                                                $selected = $status_otorisasi == $val ? 'selected' : '';
                                            @endphp
                                            @if ($val != 3 && $val != 4 && $val != 5)
                                                <option value="{{ $val }}" {{ $selected }}>
                                                    {{ $ket }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @elseif(Tmparamtertr::session('role') == 'internalcontrol')
                                    <select class="form-control" required name="status_approve" id="status_approve"
                                        required>
                                        @foreach (Tmparamtertr::status_approve() as $val => $ket)

                                            @if ($val != 1 && $val != 2)
                                                @php
                                                    $cselected = $status_otorisasi == $val ? 'selected' : '';
                                                @endphp
                                                <option value="{{ $val }}" {{ $cselected }}>
                                                    {{ $ket }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                Catatan Otorisasi
                            </td>
                            <td colspan="3">
                                <textarea name="catat_otorisasi" class="form-control" rows="12" columns="20">
                                       </textarea>
                            </td>

                        </tr>

                        <tr>
                            <td colspan="3">

                            </td>

                            <td colspan="3">
                                <button type="submit" class="btn btn-primary" id="simpan"><i
                                        class="fas fa-save"></i>Simpan</button>

                                <button type="reset" class="btn btn-warning" id="simpan"><i
                                        class="fas fa-save"></i>Cancel</button>
                            </td>

                        </tr>
                    </table>


                </form>

            @endif
        </div>

    </div>
</section>

<script type="text/javascript">
    (function() {
        'use strict';
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
    $(function() {
        $('#verifikasi').on('submit', function(e) {
            e.preventDefault();
            if ($(this)[0].checkValidity() === false) {
                e.preventDefault();
                e.stopPropagation();
            } else {
                result = "success";
                $("#verifikasi input[type=radio]:checked").each(function() {
                    if (this.value == 0 && this.checked == true) {
                        result = "fail";
                        return false;
                    }
                });
                status_approve = $('select[name="status_approve"] option:selected').val();

                @if (Tmparamtertr::session('role') == 'manageroperation')
                    if (result == 'success') {
                    if (status_approve == 2) {
                    swal.fire('error',
                    'Tidak dapat di revise ke markeing silahkan lanjutkan ke pusat',
                    'error');
                    ket = 0;
                
                    } else {
                    ket = 1;
                
                    }
                    } else {
                    if (status_approve == 1) {
                    swal.fire('error',
                    'Tidak dapat di lanjutkan mohon diperbaiki',
                    'error');
                    ket = 0;
                
                    } else {
                    ket = 1;
                
                    }
                    }
                
                
                @elseif(Tmparamtertr::session('role') == 'internalcontrol')
                    if (result == 'success') {
                    if (status_approve == 4 || status_approve == 3) {
                    swal.fire('error',
                    'jika sudah di check benar silahkan dapa di approve',
                    'error');
                    ket = 0;
                    } else {
                    ket = 1;
                    }
                    } else {
                    if (status_approve == 5) {
                    swal.fire('error',
                    'terdapat kesalahan silahkan di reject atau di revise',
                    'error');
                    ket = 0;
                
                    } else {
                    ket = 1;
                
                
                    }
                    }
                
                @endif

                if (ket == 1) {
                    $.ajax({
                        url: '{{ route('otorisasi.savedata', $no_aplikasi) }}',
                        method: "POST",
                        chace: false,
                        asynch: false,
                        data: $(this).serialize(),
                        success: function(data) {
                            if (data.status == 1) {
                                $('#datatable').DataTable().ajax.reload();
                                $('#formmodal').modal('hide');
                                swal.fire('success', data.msg, 'success');
                            } else {
                                swal.fire('error', data.msg, 'erorr');
                            }
                        },
                        error: function(data, error, jqXHr) {
                            console.log(error, jqXHr);
                        }
                    })
                }
                return false;
                // console.log(res);   
            }
        });

    });

    function detailparameter(id) {
        event.preventDefault();
        $.dialog({
            title: false,
            content: 'url:<?php echo e(route('parameter.show', ':id')); ?>'.replace(':id', id),
            animation: 'scale',
            columnClass: 'large',
            closeAnimation: 'scale',
            boxWidth: '100%',
            boxHeight: '100%',
            useBootstrap: false,
            backgroundDismiss: true,
        });
    }
</script>
