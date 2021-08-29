 <h3 class="section-title">Jenis File Jaminan Peserta</h3>
 <p>Hadiah yang di pilih : {{ $hadiah }}</p>
 @if ($level == 'manageroperation' && $approve_status == 1)
     <div class="alert alert-info"><i class="fas fa-info"></i> Status Approve Sudah di periksa marketing</div>
 @elseif($level == 'internalcontrol' && $approve_status == 2)
     <div class="alert alert-info"><i class="fas fa-info"></i> Status Approve Sudah di periksa cabang manager
         operation</div>
 @endif
 <small>Klik detail untuk melihat file yang di upload , <br /> Silahkan periksa terlebih dahulu file yang akan di cek
     dengan klik button list di bawah </small>
 <div class="card-body">
     <div class="table-responsive">
         <form id="verifikasi" class="form-horizontal">
             <table class="table table-bordered">
                 <tr>
                     <th>No. </th>
                     <th>Nama File</th>
                     <th>Detail</th>
                     <th>Veryfied</th>
                     <th colspan="2">Catatan</th>
                 </tr>
                 @php
                     $j = 0;
                 @endphp

                 @foreach ($document as $documents)
                     @php
                         $badge = $j % 2 ? 'success' : 'warning';
                         $checked_cabang_l = $documents['otorisasi_cabang']['val'] == '1' ? 'checked' : '';
                         $checked_cabang_d = $documents['otorisasi_cabang']['val'] == '0' ? 'checked' : '';
                         $catatan_cabang = $documents['catatan_cabang']['val'];
                         
                         $checked_pusat_l = $documents['otorisasi_pusat']['val'] == '1' ? 'checked' : '';
                         $checked_pusat_d = $documents['otorisasi_pusat']['val'] == '0' ? 'checked' : '';
                         $catatan_pusat = $documents['catatan_pusat']['val'];
                     @endphp


                     <tr>
                         <td>{{ $j + 1 }}</td>
                         <td>
                             <div class="badge badge-{{ $badge }}"> {{ $documents['nama_doc']['val'] }}
                             </div>
                             {{ $documents['status']['val'] }}
                         </td>
                         <td>
                             <a target="_blank" href="{{ $documents['keterangan_file']['val'] }}"
                                 class="btn btn-info btn-sm" target="_blank"> <i class="fas fa-file"></i></a>
                         </td>
                         <td>

                             @if ($level == 'manageroperation')
                                 <input type="hidden" name="nama_file[{{ $documents['nama_doc']['val'] }}]"
                                     value="{{ $documents['nama_doc']['val'] }}">

                                 <input type="radio" name="status[{{ $documents['id_par']['val'] }}]" value="1"
                                     {{ $checked_cabang_l }}>
                                 Sesuai
                                 <input type="radio" name="status[{{ $documents['id_par']['val'] }}]" value="0"
                                     {{ $checked_cabang_d }}>
                                 Tidak Sesuai
                             @elseif($level == 'internalcontrol')
                                 <input type="hidden" name="nama_file[{{ $documents['nama_doc']['val'] }}]"
                                     value="{{ $documents['nama_doc']['val'] }}">

                                 <input type="radio" name="status[{{ $documents['id_par']['val'] }}]" value="1"
                                     {{ $checked_pusat_l }}>
                                 Sesuai
                                 <input type="radio" name="status[{{ $documents['id_par']['val'] }}]" value="0"
                                     {{ $checked_pusat_d }}>
                                 Tidak Sesuai
                             @endif
                         </td>
                         <td>
                             @if ($level == 'manageroperation')
                                 <textarea class="form-control"
                                     name="catatan_{{ $j }}">{{ $catatan_cabang }}</textarea>
                             @elseif($level == 'internalcontrol')
                                 <textarea class="form-control"
                                     name="catatan_{{ $j }}">{{ $catatan_pusat }}</textarea>

                             @endif
                         </td>
                     </tr>

                     @php
                         $j++;
                     @endphp
                 @endforeach
                 <tr>
                     <td></td>
                     <td></td>
                     <td><br />Status Akhir</td>
                     <td colspan="3">
                         <br />
                         @if (Tmparamtertr::session('role') == 'manageroperation')
                             <select class="form-control" required name="status_approve" id="jenis_hadiah">
                                 @foreach (Tmparamtertr::status_approve_verifikasi() as $val => $ket)
                                     @php
                                         $selected = $status_approve == $val ? 'selected' : '';
                                     @endphp
                                     @if ($val != 3 && $val != 4 && $val != 5))
                                         <option value="{{ $val }}" {{ $selected }}>
                                             {{ $ket }}</option>
                                     @endif
                                 @endforeach
                             </select>
                         @elseif(Tmparamtertr::session('role') == 'internalcontrol')
                             <select class="form-control" required name="status_approve" id="jenis_hadiah">
                                 @foreach (Tmparamtertr::status_approve_verifikasi() as $val => $ket)

                                     @if ($val != 1 && $val != 2)
                                         @php
                                             $cselected = $status_approve == $val ? 'selected' : '';
                                         @endphp
                                         <option value="{{ $val }}" {{ $cselected }}>
                                             {{ $ket }}</option>
                                     @endif
                                 @endforeach
                             </select>
                         @endif

                     </td>
                 </tr>
             </table>

             <hr />
             <button type="submit" class="btn btn-primary" id="simpan"><i class="fas fa-save"></i>Simpan</button>

             <button type="reset" class="btn btn-warning" id="simpan"><i class="fas fa-save"></i>Cancel</button>

     </div>
     </form>
 </div>

 <script type="text/javascript">
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
                     'Tidak dapat di revise ke backoffice silahkan lanjutkan ke pusat',
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
                         url: "{{ route('verifikasikelengkapan.update', $no_aplikasi) }}",
                         method: "PUT",
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
 </script>
