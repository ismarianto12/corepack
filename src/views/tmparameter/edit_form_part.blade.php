 {{-- $f->id = $this->primary_id; --}}
 {{-- {{ $id }} --}}
 <form class="update needs-validation" novalidate>
     @csrf
     <div id="myTabContent" class="tab-content">
         <div id="program" role="tabpanel" aria-labelledby="program-tab" class="tab-pane fade px-4 py-5 show active">
             <div class="form-group row">

                 <label for="kode" class="col-md-2 text-left">Kode Program</label>
                 <div class="col-md-4">
                     <input type="text" name="kode_prog" value="{{ $kode_prog }}" id="kode_prog" class="form-control"
                         required>
                     <div class="help-block with-errors"></div>

                 </div>
                 <label for="nama_prog" class="col-md-2 text-left">Nama Program</label>
                 <div class="col-md-4">
                     <input type="text" name="nama_prog" value="{{ $nama_prog }}" class="form-control" required
                         id="nama_prog" required>
                 </div>
             </div>

             <div class="form-group row">
                 <label for="usia_peserta_min" class="col-md-2 text-left">Usia Peserta</label>
                 <div class="col-md-4">
                     <table class="table">
                         <tr>
                             <td>Minimal</td>
                             <td><input type="text" name="usia_peserta_min" value="{{ $usia_peserta_min }}"
                                     class="form-control" required></td>
                             <td>Max</td>
                             <td><input type="text" name="usia_peserta_max" value="{{ $usia_peserta_max }}"
                                     class="form-control" required></td>
                         </tr>
                         <tr>
                             <td>Overide</td>
                             <td colspan="3">
                                 {!! Tmparamtertr::getoveride('overide_usia[]', $overide_usia) !!}
                             </td>
                         </tr>
                     </table>
                 </div>

                 <label for="usia_peserta_max" class="col-md-2 text-left">Usia Penerima Manfaat</label>
                 <div class="col-md-4">
                     <table class="table">
                         <tr>
                             <td>Minimal</td>
                             <td><input type="text" name="usia_penerima_manfaat_min"
                                     value="{{ $usia_penerima_manfaat_min }}" class="form-control" required></td>
                             <td>Max</td>
                             <td><input type="text" name="usia_penerima_manfaat_manmax"
                                     value="{{ $usia_penerima_manfaat_manmax }}" class="form-control" required>
                             </td>
                         </tr>
                         <tr>
                             <td>Overide</td>
                             <td colspan="3">
                                 {!! Tmparamtertr::getoveride('overide_penerima_manfaat[]', $overide_penerima_manfaat) !!}

                             </td>
                         </tr>
                     </table>
                 </div>

             </div>
             <div class="form-group row">
                 <label for="hubungan_p_penerimamanfaat" class="col-md-2 text-left">Hubungan Peserta & Penerima
                     Manfaat</label>
                 <div class="col-md-4">
                     <table class="table">
                         <tr>
                             <td>Jumlah</td>
                             <td>
                                 <select class="form-control select2" required name="jumlah_penerima_manfaat" required>
                                     @for ($i = 1; $i <= 7; $i++)
                                         @php
                                             $slt = $jumlah_penerima_manfaat == $i ? 'selected' : '';
                                         @endphp

                                         <option value="{{ $i }}" {{ $slt }}>{{ $i }}
                                         </option>
                                     @endfor
                                 </select>
                             </td>
                         </tr>
                         <tr>
                             <td>Jenis</td>
                             <td>
                                 {{-- @dd($jenisnya[1]); --}}
                                 <select name="jenis_hubungan_manfaat[]" class="form-control select2"
                                     multiple="multiple" required>
                                     <option value=""></option>
                                     @php
                                         $v = 0;
                                     @endphp
                                     @foreach ($jenisnya as $key => $value)
                                         @php
                                             if (strpos($jenis_hubungan_manfaat, $value) === false) {
                                                 $selected = '';
                                             } else {
                                                 $selected = 'selected';
                                             }
                                         @endphp
                                         <option value="{{ $key }}" {{ $selected }}>{{ $value }}
                                         </option>

                                         @php
                                             $v++;
                                         @endphp
                                     @endforeach

                                 </select>
                             </td>
                         </tr>
                         <tr>
                             <td>Overide</td>
                             <td colspan="3">
                                 {!! Tmparamtertr::getoveride('overide_hubungan[]', $overide_hubungan) !!}
                             </td>

                         </tr>
                     </table>
                 </div>

                 <label for="setoran_awal" class="col-md-2 text-left">Setoran Awal</label>
                 <div class="col-md-4">
                     <input type="text" name="setoran_awal" value="{{ Tmparamtertr::curency($setoran_awal) }}"
                         class="number_format form-control" required>
                 </div>
             </div>


             <div class="form-group row">
                 <label for="nilai_manfaat_hadiah" class="col-md-2 text-left"> Nilai Manfaat Hadiah</label>
                 <div class="col-md-4">
                     <input type="text" name="nilai_manfaat_hadiah"
                         value="{{ Tmparamtertr::curency($nilai_manfaat_hadiah) }}"
                         class="number_format form-control" required>
                 </div>

                 <label for="setoran_rutin" class="col-md-2 text-left">Indikasi Manfaat (%)</label>
                 <div class="col-md-4">
                     <input type="text" name="indikasi_manfaat"
                         value="{{ Tmparamtertr::curency($indikasi_manfaat) }}"
                         placeholder="Persentase Indikasi manfaat" class="form-control" required>

                 </div>

             </div>
             <div class="form-group row">
                 <label for="saldo_rencana" class="col-md-2 text-left">Pajak Hadiah (%)</label>
                 <div class="col-md-4">
                     <input type="text" name="pajak_hadiah" value="{{ $pajak_hadiah }}" class="form-control"
                         required>
                 </div>


                 <label for="jangka_waktu" class="col-md-2 text-left">Jangka Waktu</label>
                 <div class="col-md-2">
                     <input style="width:70px" type="number" name="jangka_waktu" value="{{ $jangka_waktu }}"
                         class="form-control" required> /
                     Bulan
                 </div>
             </div>

         </div>
         <div id="produk" role="tabpanel" aria-labelledby="produk-tab" class="tab-pane fade px-4 py-5">
             {{-- tab panel untuk produk --}}

             <div class="form-group row">

                 <label for="kode_rek_haji_pmanfaat" class="col-md-2 text-left">Kode Produk Terkait</label>
                 <div class="col-md-4">

                     <input type="text" name="kode_rek_haji_pmanfaat" value="{{ $kode_rek_haji_pmanfaat }}"
                         id="kode_rek_haji_pmanfaat" class="form-control" required>
                     <br />
                     <select class="form-control" required>
                         <option value="otomatis">Otomatis </option>
                         <option value="manual">Kondisi </option>
                     </select>
                     <br />
                 </div>
                 <label for="kode_prouduk_rencana" class="col-md-2 text-left">Kode Produk Rencana</label>
                 <div class="col-md-4">

                     <input type="text" name="kode_prouduk_rencana" value="{{ $kode_prouduk_rencana }}"
                         class="form-control" required>
                     <br />
                     <select class="form-control" required>
                         <option value="otomatis">Otomatis </option>
                         <option value="manual">Kondisi </option>
                     </select>
                     <br />

                 </div>
             </div>
             {{-- membuat jumlah --}}
             <div class="form-group row">
                 <label for="kode_rek_haji_pmanfaat" class="col-md-2 text-left">1. Kode Rek. Haji Penerima
                     Manfaat</label>
                 <div class="col-md-4">

                     <input type="text" name="kode_rek_haji_pmanfaat" id="kode_rek_haji_pmanfaat"
                         value="{{ $kode_rek_haji_pmanfaat }}" class="form-control" required>
                     <br />
                     <select id="kode_rek_haji_pmanfaat" class="form-control" required>
                         <option value="otomatis">Otomatis </option>
                         <option value="manual">Kondisi </option>
                     </select>
                     <br />
                 </div>
                 <label for="kode_rek_haji_rthj" class="col-md-2 text-left">2. Kode Rek. RTJH
                     Penerima Manfaat</label>
                 <div class="col-md-4">
                     <input type="text" name="kode_rek_haji_rthj" value="{{ $kode_rek_haji_rthj }}"
                         class="form-control" required>
                     <br />
                     <select name="status" id="kode_rek_haji_rthj" class="form-control" required>
                         <option value="otomatis">Otomatis </option>
                         <option value="manual">Kondisi </option>
                     </select>
                     <br />
                 </div>
             </div>

         </div>
         <div id="rekening" role="tabpanel" aria-labelledby="rekening-tab" class="tab-pane fade px-4 py-5">
             {{-- tab panel untuk paramerter --}}
             <h3 class="section-title">Parameter Rekening Rencana Rutin</h3>
             <div class="form-group row">
                 <label for="setoran_rutin" class="col-md-2 text-left">Setoran Rutin </label>
                 <div class="col-md-4">
                     <input type="text" name="setoran_rutin" value="{{ Tmparamtertr::curency($setoran_rutin) }}"
                         class="number_format form-control" required>
                 </div>

                 <label for="saldo_rencana" class="col-md-2 text-left">Saldo rencana
                     <br />
                     <small>Besaran Saldo Rencana Untuk Tabungan ZAM - ZAM </small>
                 </label>
                 <div class="col-md-4">
                     <input type="text" name="saldo_rencana" value="{{ Tmparamtertr::curency($saldo_rencana) }}"
                         class="number form-control" required>
                 </div>
             </div>
             <div class="form-group row">
                 <label for="tgl_pendebetan" class="col-md-2 text-left">Tanggal Pendebetan</label>
                 <div class="col-md-4">
                     <input type="date" name="tgl_pendebetan" value="{{ $tgl_pendebetan }}" class="form-control"
                         required>
                 </div>
                 <label for="setoran_awwal_lanjutan" class="col-md-2 text-left">Setoran Awal Lanjutan <br />
                     <small>Bidang berfungsi untuk program tazam lanjutan</small>
                 </label>
                 <div class="col-md-4">
                     <input type="text" name="setoran_awwal_lanjutan"
                         value="{{ Tmparamtertr::curency($setoran_awwal_lanjutan) }}"
                         class="number_format form-control" required>
                 </div>
             </div>
             <hr />
             <h3 class="section-title">Parameter Biaya - Biaya</h3>
             <div class="form-group row">
                 <label for="biayahadiah" class="col-md-2 text-left">Biaya Hadiah</label>
                 <div class="col-md-4">
                     <input type="text" name="biayahadiah" value="{{ Tmparamtertr::curency($biayahadiah) }}"
                         class="number_format form-control" required>
                     <hr />
                     <table class="table table-bordered">
                         <tr>
                             <td>Debet</td>
                             <td><input type="text" name="debet_biaya_hadiah" value="{{ $debet_biaya_hadiah }}"
                                     class="form-control" placeholder="Debet biaya hadiah ..."></td>

                         </tr>
                         <tr>
                             <td>Kredit</td>

                             <td><input type="text" name="kredit_biaya_hadiah" class="form-control"
                                     value="{{ $kredit_biaya_hadiah }}" placeholder="Kredit biaya hadiah ..."></td>
                         </tr>
                     </table>
                 </div>
                 <label for="jenis_amortisasi" class="col-md-2 text-left">Jenis Amortisasi</label>
                 <div class="col-md-4">
                     <select class="form-control" name="jenis_amortisasi" required>
                         @foreach (PhareSpase::jamort() as $jamors => $val)
                             @php
                                 $selef = $jenis_amortisasi == $jamors ? 'selected' : '';
                             @endphp
                             <option value="{{ $jamors }}" {{ $selef }}>{{ $val }}</option>
                         @endforeach
                     </select>
                 </div>
             </div>

             <div class="form-group row">
                 <label for="beban_pajak" class="col-md-2 text-left">Beban Pajak</label>
                 <div class="col-md-4">
                     <input type="number" name="beban_pajak" value="{{ $beban_pajak }}" class="form-control"
                         required>
                 </div>
                 <label for="biaya_pengurusan" class="col-md-2 text-left">Biaya Pengurusan</label>
                 <div class="col-md-4">
                     <input type="text" name="biaya_pengurusan" value="{{ $biaya_pengurusan }}"
                         class="number_format form-control" required>
                     <hr />
                     <table class="table table-bordered">
                         <tr>
                             <td>Debet</td>
                             <td><input type="text" name="debet_biaya_pengurusan"
                                     value="{{ $debet_biaya_pengurusan }}" class="form-control"
                                     placeholder="Debet biaya hadiah ..."></td>
                         </tr>
                         <tr>
                             <td>Kredit</td>
                             <td><input type="text" name="kredit_biaya_pengurusan"
                                     value="{{ $kredit_biaya_pengurusan }}" class="form-control"
                                     placeholder="Kredit biaya hadiah ..."></td>
                         </tr>
                     </table>
                 </div>
             </div>

             <div class="form-group row">
                 <label for="biaya_perencanaan" class="col-md-2 text-left">Biaya Perencanaan</label>
                 <div class="col-md-4">
                     <input type="text" name="biaya_perencanaan" value="{{ $biaya_perencanaan }}"
                         class="number_format form-control" required>
                     <hr />
                     <table class="table table-bordered">
                         <tr>
                             <td>Debet</td>
                             <td>
                                 <input type="text" name="debet_biaya_perencanaan"
                                     value="{{ $debet_biaya_perencanaan }}" class="form-control"
                                     placeholder="Debet biaya perencanaan ..." required>
                             </td>
                         </tr>
                         <tr>
                             <td>Kredit</td>
                             <td><input type="text" name="kredit_biaya_perencanaan"
                                     value="{{ $kredit_biaya_perencanaan }}" class="form-control"
                                     placeholder="Kredit biaya perencanaan ..." required></td>
                         </tr>
                     </table>
                 </div>
                 <label for="cara_pendebetan" class="col-md-2 text-left">Cara Pendebetan</label>
                 <div class="col-md-4">
                     <select class="form-control" required name="cara_pendebetan">
                         @php
                             $cra = [
                                 'rekening' => 'Rekening',
                                 'subsystem' => 'Subsystem',
                             ];
                         @endphp
                         @foreach ($cra as $cras => $crasfuck)
                             @php
                                 $selected = $crasfuck == $cara_pendebetan ? 'selected' : '';
                             @endphp
                             <option value="{{ $cras }}" value="{{ $selected }}">{{ $crasfuck }}
                             </option>
                         @endforeach
                     </select>
                     {{-- table debet biaya --}}
                 </div>
             </div>
         </div>

         <div id="jenisd" role="tabpanel" aria-labelledby="jenisd-tab" class="tab-pane fade px-4 py-5">
             {{-- tab panl untuk jenis dan docuemtn --}}
             <h3 class="section-title">Jenis Hadiah dan Dokumen Peserta</h3>
             <hr />

             <div class="form-group row">
                 <label for="biayapenutupanprog" class="col-md-2 text-left">Jenis Hadiah </label>
                 <div class="col-md-4">
                     <select class="form-control" name="jenis_hadiah_peserta" id="jenis_hadiah_peserta">
                         <option value="">Jenis Hadiah Peserta</option>
                         @foreach ($tmhhadiah as $tmhadias)
                             @php
                                 $hadiahsel = $tmhadias->id == $jenis_hadiah_peserta ? 'selected' : '';
                             @endphp
                             <option value="{{ $tmhadias->id }}" {{ $hadiahsel }}>
                                 {{ $tmhadias->jenis_hadiah }}</option>
                         @endforeach
                     </select>
                 </div>

                 <label for="biayapenutupanprog" class="col-md-2 text-left">Jenis Hadiah Penerima Manfaat</label>
                 <div class="col-md-4">
                     <select class="form-control" required name="jenis_hadiah_manfaat" id="jenis_hadiah_manfaat">
                         <option value="">Pilih Jenis Hadiah manfaat</option>
                         @foreach ($tmhhadiah as $tmhadias)
                             @php
                                 $penhadiahsel = $tmhadias->id == $jenis_hadiah_manfaat ? 'selected' : '';
                             @endphp

                             <option value="{{ $tmhadias->id }}" {{ $penhadiahsel }}>
                                 {{ $tmhadias->jenis_hadiah }}</option>
                         @endforeach
                     </select>
                 </div>
             </div>

             <div class="form-group row" id="overide_hadiah_peserta">
                 <label for="overide_hadiah_peserta" class="col-md-2 text-left">Pilih Overide Peserta</label>
                 <div class="col-md-4">
                     {!! Tmparamtertr::getoveride('user_overide_jenhadiah_peserta[]', $user_overide_jenhadiah_peserta) !!}
                 </div>
             </div>


             <div class="form-group row" id="overide_hadiah_pmanfaat">
                 <label for="overide_hadiah_pmanfaat" class="col-md-2 text-left">Pilih Overide Penerima Manfaat</label>
                 <div class="col-md-4">
                     {!! Tmparamtertr::getoveride('user_overide_jenhadiah_manfaat[]', $user_overide_jenhadiah_manfaat) !!}
                 </div>
             </div>

             <br />
             <h3 class="section-title">SLIK Parameter </h3>
             <hr />
             <div class="form-group row">
                 <label for="biayapenutupanprog" class="col-md-2 text-left">Status Slik </label>
                 <div class="col-md-4">
                     <select class="form-control" required name="status_slik">
                         <option value="">--Pilih status slik--</option>
                         @php
                             $ssaldo = [
                                 1 => 'Set Status (Otomatis)',
                                 2 => 'Set Status Manual ',
                             ];
                         @endphp
                         @foreach ($ssaldo as $ssaldos => $key)
                             @php
                                 $selected = $ssaldos == $status_slik ? 'selected' : '';
                             @endphp
                             <option value="{{ $ssaldos }}">{{ $key }}</option>
                         @endforeach
                     </select>
                 </div>
                 <label for="biayapenutupanprog" class="col-md-2 text-left">Status Pengecekan Saldo </label>

                 <div class="col-md-4">
                     <select class="form-control" required name="pengecekan_saldo">
                         <option value="">--Pilih status Pengecekan Saldo--</option>
                         @php
                             $ssaldo = [
                                 1 => 'Iya',
                                 2 => 'Tidak',
                             ];
                         @endphp
                         @foreach ($ssaldo as $ssaldos => $key)
                             @php
                                 $selected = $ssaldos == $pengecekan_saldo ? 'selected' : '';
                             @endphp
                             <option value="{{ $ssaldos }}">{{ $key }}</option>
                         @endforeach

                     </select>
                     <small>Jika feature ini diaktifkan maka pengecekan saldo akan di lakukan di subsystem. </small>
                 </div>
             </div>
         </div>


         {{-- jenis dan besaran insentif --}}
         <div id="fee" role="tabpanel" aria-labelledby="fee-tab" class="tab-pane fade px-4 py-5">
             <h4 class="section-title">Insentif Awal </h4>
             <div class="form-group row">
                 <label for="insentif_awal_marketing" class="number_format col-md-2 text-left">Insentif Awal
                     Marketing</label>
                 <div class="col-md-4">
                     <input type="text" name="insentif_awal_marketing"
                         value="{{ Tmparamtertr::curency($insentif_awal_marketing) }}"
                         class="number_format form-control" required>

                     <table class="table table-responsive">
                         <tr>
                             <td>Debet</td>
                             <td colspan="3">
                                 <input type="text" name="kredit_biaya_pengurusan" class="form-control" placeholder="">
                             </td>
                         </tr>
                         <tr>
                             <td>Kredit</td>
                             <td colspan="3"><input type="text" name="kredit_biaya_pengurusan" class="form-control"
                                     placeholder=""></td>
                         </tr>
                     </table>
                 </div>

                 <label for="insentif_pihakke3" class="col-md-2 text-left">Insentif Awal Pihak Ketiga</label>
                 <div class="col-md-4">
                     <input type="text" name="insentif_pihakke3"
                         value="{{ Tmparamtertr::curency($insentif_pihakke3) }}" class="number_format form-control"
                         required>

                     <table class="table table-responsive">
                         <tr>
                             <td>Debet</td>
                             <td colspan="3">
                                 <input type="text" name="kredit_biaya_pengurusan" class="form-control" placeholder="">
                             </td>
                         </tr>
                         <tr>
                             <td>Kredit</td>
                             <td colspan="3"><input type="text" name="kredit_biaya_pengurusan" class="form-control"
                                     placeholder=""></td>
                         </tr>
                     </table>

                 </div>
             </div>

             <br />

             <h3 class="section-title">Insentif Bulanan</h3>

             <div class="form-group row">
                 <label for="insentif_bulanan_marketing" class="col-md-2 text-left">Insentif Bulanan Marketing</label>
                 <div class="col-md-4">
                     <input type="text" name="insentif_bulanan_marketing"
                         value="{{ Tmparamtertr::curency($insentif_bulanan_marketing) }}"
                         class="number_format form-control" required>

                     <table class="table table-responsive">
                         <tr>
                             <td>Debet</td>
                             <td colspan="3">
                                 <input type="text" name="kredit_biaya_pengurusan" class="form-control" placeholder="">
                             </td>
                         </tr>
                         <tr>
                             <td>Kredit</td>
                             <td colspan="3"><input type="text" name="kredit_biaya_pengurusan" class="form-control"
                                     placeholder=""></td>
                         </tr>
                     </table>


                 </div>
                 <label for="insentif_bulanan_pihak3" class="col-md-2 text-left">Insentif Bulanan Pihak Ketiga</label>
                 <div class="col-md-4">
                     <input type="text" name="insentif_bulanan_pihak3"
                         value="{{ Tmparamtertr::curency($insentif_bulanan_pihak3) }}"
                         class="number_format form-control" required>
                     <table class="table table-responsive">
                         <tr>
                             <td>Debet</td>
                             <td colspan="3">
                                 <input type="text" name="kredit_biaya_pengurusan" class="form-control" placeholder="">
                             </td>
                         </tr>
                         <tr>
                             <td>Kredit</td>
                             <td colspan="3"><input type="text" name="kredit_biaya_pengurusan" class="form-control"
                                     placeholder=""></td>
                         </tr>
                     </table>

                 </div>
             </div>
         </div>
         <div class="form-group row">
             <button id="btnsimpan" class="btn btn-info btn-lg" type="submit"><i class="fas fa-save
           "></i>Update Data</button>&nbsp;&nbsp;&nbsp;
             <button id="btnreset" class="btn btn-warning btn-lg" type="reset"><i class="fas fa-reset
           "></i>Reset</button>
         </div>
     </div>
     <hr />
 </form>

 <script>
     (function() {
         'use strict';
         var forms = document.getElementsByClassName('needs-validation');
         var validation = Array.prototype.filter.call(forms, function(form) {
             form.addEventListener('submit', function(event) {
                 if (form.checkValidity() === false) {
                     event.preventDefault();
                     event.stopPropagation();

                     swal.fire('error',
                         'Silahkan check inputan yang kosog dan format inputan yang salah',
                         'error');
                 }
                 form.classList.add('was-validated');
             }, false);
         });

     })();
     // selected value
     $(function() {

         $('.select2').select2();

         kode_rek_haji_pmanfaat = $('#kode_rek_haji_pmanfaat').find(":selected").val();
         kode_rek_haji_rthj = $('#kode_rek_haji_rthj').find(":selected").val();


         $('#kode_rek_haji_pmanfaat').on('change', function() {
             var kode_rek_haji_pmanfaat = $(this).val();
             if (kode_rek_haji_pmanfaat == 'otomatis') {
                 $('input[name="kode_rek_haji_pmanfaat"]').val('TWHAJI20');
             } else if (kode_rek_haji_pmanfaat == 'manual') {
                 $('input[name="kode_rek_haji_pmanfaat"]').val('');
             }
         });
         $('#kode_rek_haji_rthj').on('change', function() {
             var kode_rek_haji_rthj = $(this).val();
             if (kode_rek_haji_rthj == 'otomatis') {
                 $('input[name="kode_rek_haji_rthj"]').val('RTJH');
             } else if (kode_rek_haji_rthj == 'manual') {
                 $('input[name="kode_rek_haji_rthj"]').val('');


             }
         });




         // end function
         $('#overide_hadiah_peserta').hide();
         $('#overide_hadiah_pmanfaat').hide();

         $('#jenis_hadiah_peserta').on('change', function() {
             var hadiah = $(this).val();
             if (hadiah == 1) {
                 $('#overide_hadiah_peserta').hide();
             } else {
                 $('#overide_hadiah_pmanfaat').show();
             }
         });
         $('#jenis_hadiah_manfaat').on('change', function() {
             var fhadiah = $(this).val();
             if (fhadiah == 1) {
                 $('#overide_hadiah_pmanfaat').hide();
             } else {
                 $('#overide_hadiah_peserta').show();
             }
         });


         @include('tazamcore::layouts.tablechecked');

         $('#table_penutupan_program').html('<center><h3>Loading Form Harap Bersabar ...</h3></center>').load(
             '{{ route('tablebiaya_list') }}');

         $('#thadiah_peserta').html(
             '<div class="col-md-8"><div class="alert alert-info"><i class="fas fa-user"></i>Silahkan pilih jenis document dan jenis hadiah peserta</div></div>'
         );

         $('#thadiah_pmanfaat').html(
             '<div class="col-md-8"><div class="alert alert-warning"><i class="fas fa-user"></i>Silahkan pilih jenis document dan jenis hadiah penerima manfaat</div></div>'
         );
     });

     function hapus_biaya_del(e) {
         event.preventDefault();
         $.confirm({
             title: '',
             content: 'Apakah Anda yakin akan menghapus data ini?',
             icon: 'icon icon-question amber-text',
             theme: 'modern',
             closeIcon: true,
             animation: 'scale',
             type: 'red',
             buttons: {
                 ok: {
                     text: 'ok!',
                     btnClass: 'btn-primary',
                     keys: ['enter'],
                     action: function() {
                         hapus();
                     }
                 },
                 cancel: function() {}
             }
         });
     }
 </script>
