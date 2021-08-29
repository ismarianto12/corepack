 <div class="container">

     <h3 class="section-title">Jenis File Jaminan Ismarianto Peserta</h3>
     <p>Hadiah yang di pilih : {{ $hadiah }}</p>

     <div class="table-responsive">
         <form id="simpan" class="needs-validation" novalidate>

             <table class="table table-bordered">
                 <tr>
                     <th>#</th>
                     <th>Nama File</th>
                     <th>Ket</th>
                     <th>Action</th>
                 </tr>
                 @php
                     $j = 1;
                 @endphp
                 @foreach ($document as $documents)
                     @php
                         $badge = $j % 2 ? 'success' : 'warning';
                         $status = $documents['keterangan_file']['val'] ? 'disabled' : '';
                     @endphp
                     <input type="hidden" name="peserta[{{ $documents['id_par']['val'] }}]"
                         id="peserta{{ $documents['id_par']['val'] }}" value="" required>
                     <tr>
                         <td>{{ $j }}</td>
                         <td>
                             <div class="badge badge-{{ $badge }}">
                                 {{ str_replace(',', '', $documents['nama_doc']['val']) }}
                             </div>

                             <i>Status : {{ $documents['status']['val'] }}</i>

                         </td>
                         <td>
                             <button name="fileupload"
                                 class="participant{{ $documents['id_par']['val'] }} btn btn-primary btn-sm">
                                 Browse</button>
                             <br />
                         </td>
                         <td>
                             @if ($documents['keterangan_file']['val'] != '' || $documents['nama_file']['val'] != '')
                                 <div class="peserta{{ $documents['id_par']['val'] }}">
                                     <a href="{{ $documents['nama_file']['val'] }}" class="btn btn-primary btn-sm"
                                         target="_blank"><i class="fa fa-eye"></i>Lihat</a>
                                 </div>
                             @else
                                 <div class="peserta{{ $documents['id_par']['val'] }}">
                                 </div>
                             @endif
                         </td>
                     </tr>
                     @php
                         $j++;
                     @endphp
                 @endforeach

             </table>
             <br /> <br />
             <br />

             <hr />
             <div class="form-group">
                 <button id="btnsimpan" class="btn btn-primary btn-md" type="submit"><i
                         class="fas fa-save
                                                                                                                                                                                                                                                                                                                                                         "></i>Simpan
                     Data</button>&nbsp;&nbsp;&nbsp;
                 <button id="btnreset" class="btn btn-warning btn-md" type="reset"><i
                         class="fas fa-reset
                                                                                                                                                                                                                                                                                                                                                         "></i>Reset</button>
             </div>
         </form>
     </div>


 </div>

 @php
     $f = 1;
 @endphp
 @foreach ($document as $documents)
     @php
         $document_id = $documents['id_par']['val'];
     @endphp
     <script type="text/javascript">
         $(function() {
             @if ($documents['nama_file']['val'] == '')
                 $('.peserta{{ $document_id }}').html(
                 '<a class="btn btn-warning btn-sm"><i class="fa fa-loading"></i>Progress ..</a>'
                 );
             @else
             @endif

             $('.participant{{ $document_id }}').on('click', function(e) {
                 e.preventDefault();
                 $('#karambia').modal('show');
                 var url_upload =
                     '{{ Url('filemanager/dialog.php') }}?field_id=peserta{{ $document_id }}&lang=en_EN&akey=@filemanager_get_key()&fldr=/';
                 $('.modal-body').html(
                     '<iframe style="width: 100%; height:500px; border: none" src="' +
                     url_upload + '"></iframe>');
             });
         });

         function responsive_filemanager_callback(field_id) {
             console.log(field_id);
             var url = jQuery('#' + field_id).val();
             $('.' + field_id).html('<a href="' + url +
                 '" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-check"></i>Detail File</a>');
         }
     </script>

     @php
         $f++;
     @endphp
 @endforeach



 @section('script')

     <div class="modal fade" id="karambia" role="dialog" aria-hidden="true">
         <div class="modal-dialog" role="document" style=" min-width: 100%;">
             <div class="modal-content">
                 <div class="modal-header border-0">
                     <h5 class="modal-title" id="title">
                     </h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                 </div>

             </div>
         </div>
     </div>
 @endsection
