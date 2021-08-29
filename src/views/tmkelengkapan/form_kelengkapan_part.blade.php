 <style type="text/css">
     .btn-upload {
         position: relative;
         overflow: hidden;
         display: inline-block;
     }

     .btn-upload input[type=file] {
         position: absolute;
         opacity: 0;
         z-index: 0;
         max-width: 100%;
         height: 100%;
         display: block;
     }

     .btn-upload .btn {
         padding: 8px 20px;
         background: #337ab7;
         border: 1px solid #2e6da4;
         color: #fff;
         border: 0;
         border-radius: unset;
     }

     .btn-upload:hover .btn {
         padding: 8px 20px;
         background: #2e6da4;
         color: #fff;
         border: 0;
     }

 </style>


 <div class="table-responsive">
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
         {{-- @dd($parcipcant_docs); --}}

         @if (!$parcipcant_docs)
             <td colspan="4">Untuk jenis hadiah tertentu selain haji document belum di setting .</td>
         @else
             @foreach ($parcipcant_docs as $documents)
                 @php
                     $badge = $j % 2 ? 'success' : 'warning';
                 @endphp
                 <tr>
                     <td>{{ $j }}</td>
                     <td>
                         {{ $documents['nama_doc']['val'] }}
                         <br />
                         <small>{{ $documents['status']['val'] }}</small>
                         <br />
                         {!! $documents['file_overide']['val'] !!}

                     </td>
                     <td>
                         <input type="hidden" name="tmparameter_doc_id" value="{{ $documents['id_par']['val'] }}">
                         <input type="hidden" name="idfilepeserta[{{ $documents['idfilepeserta']['val'] }}]"
                             value="{{ $documents['idfilepeserta']['val'] }}">

                         <input type="hidden" name="parameter" value="file_upload_peserta">
                         <input type="hidden" name="peserta[{{ $documents['id_par']['val'] }}]"
                             id="peserta{{ $documents['id_par']['val'] }}"
                             value="{{ $documents['keterangan_file']['val'] }}">
                         <button name="fileupload"
                             class="participant{{ $documents['id_par']['val'] }} btn btn-info btn-md">
                             <i class="fa fa-file"></i>Browse</button>
                         <br />
                     </td>
                     <td>

                         @if ($documents['keterangan_file']['val'] != '')
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
         @endif
     </table>
 </div>


 <div class="penerima_manfaat">

     @php
         $n = 1;
     @endphp
     @foreach ($getpenerimamanfaat as $pmanfaats)
         <h3 class="section-title">Penerima Manfaat ke {{ $n }}</h3>
         <hr />
         <div class="row">
             <div class="col-12">
                 <div class="form-group row">
                     <label for="kode" class="col-md-2 text-left">Nama</label>

                     <div class="col-md-4">
                         <input disabled type="text" name="nama_{{ $j }}" class="form-control"
                             value="{{ $pmanfaats->nama }}">
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="kode" class="col-md-2 text-left">Usia Penerima Manfaat</label>
                     <div class="col-md-4">
                         <input disabled type="text" name="usia_{{ $j }}" class="form-control"
                             value="{{ $pmanfaats->usia }}">
                     </div>
                     <label for="kode" class="col-md-2 text-left">Hubungan</label>
                     <div class="col-md-4">
                         <input disabled type="text" name="hubungan_{{ $j }}" class="form-control"
                             value="{{ $pmanfaats->hubungan }}">
                     </div>
                 </div>
                 <div class="form-group row">
                     <label for="kode" class="col-md-2 text-left">Pilihan Hadiah</label>
                     <div class="col-md-4">
                         <select name="tmhadiah_id_{{ $j }}" class="form-control" disabled>
                             @foreach ($tmhadiah as $tmhadiahs)
                                 @php
                                     $selected = $tmhadiahs->id == $pmanfaats->tmhadiah_id ? 'selected' : '';
                                 @endphp
                                 <option value="{{ $tmhadiahs->id }}" {{ $selected }}>
                                     {{ $tmhadiahs->jenis_hadiah }}</option>
                             @endforeach

                         </select>

                     </div>
                     <label for="kode" class="col-md-2 text-left">Nomor HP</label>
                     <div class="col-md-4">
                         <input disabled type="text" name="no_hp_{{ $j }}" class="form-control"
                             value="{{ $pmanfaats->no_hp }}">
                     </div>
                 </div>

             </div>
         </div>

         <br />
         <input type="hidden" name="trpenerima_manfaat_id" value="{{ $pmanfaats->id }}">
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
             @foreach ($recipients_docs as $srecipients_docs)
                 @php
                     $badge = $j % 2 ? 'success' : 'warning';
                     $idfilenya = $srecipients_docs['id_par']['val'];
                 @endphp
                 <input type="hidden" name="trpenerimamanfaat_id" value="{{ $pmanfaats->id }}">
                 <input type="hidden" name="idfilepmanfaat" value="{{ $srecipients_docs['idfilepmanfaat']['val'] }}">
                 <input type="hidden" name="tmparameter_doc_idpmanfaat"
                     value="{{ $srecipients_docs['id_par']['val'] }}">
                 <tr>
                     <td>{{ $j }}</td>
                     <td>
                         {{ $srecipients_docs['nama_doc']['val'] }}
                         <br />
                         <small> {{ $srecipients_docs['status']['val'] }}</small>
                         <br />
                         {!! $srecipients_docs['file_overide_pmanfaat']['val'] !!}
                     </td>
                     <td>
                         <button name="fileupload"
                             class="pmanfaatupload_{{ $n . $idfilenya }} btn btn-primary btn-md">
                             Browse</button>
                         <br />
                     </td>
                     <td>
                         <input type="hidden" name="parameter" value="file_upload_penerima_manfaat">

                         <input type="hidden" name="idfilepmanfaat[{{ $srecipients_docs['idfilepmanfaat']['val'] }}]"
                             value="{{ $srecipients_docs['idfilepmanfaat']['val'] }}">

                         <input type="hidden" name="fpmanfaat[{{ $n . $idfilenya }}]"
                             id="fpmanfaat{{ $n . $idfilenya }}"
                             value="{{ $srecipients_docs['keterangan_file']['val'] }}">
                         <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                             <div id="receipents{{ $n }}_{{ $srecipients_docs['id_par']['val'] }}">
                                 @if ($srecipients_docs['keterangan_file']['val'] != '')

                                     <div class="fpmanfaat{{ $n . $idfilenya }}">
                                         <a href="{{ $srecipients_docs['keterangan_file']['val'] }}"
                                             class="btn btn-info btn-sm" target="_blank"><i
                                                 class="fa fa-eye"></i>Lihat</a>
                                     </div>
                                     <br>

                                 @else
                                     <div class="fpmanfaat{{ $n . $idfilenya }}"></div>
                                 @endif
                             </div>
                         </div>
                     </td>
                 </tr>
                 @php
                     $j++;
                 @endphp
             @endforeach
         </table>



         {{-- uploda data form another that function here --}}
         @foreach ($recipients_docs as $srecipients_docs)
             @php
                 $idfilenya = $srecipients_docs['id_par']['val'];
             @endphp
             <script type="text/javascript">
                 @if ($srecipients_docs['nama_file']['val'] == '')
                     $('.fpmanfaat{{ $n . $idfilenya }}').html(
                     '<button class="btn btn-warning btn-md"><i class="fa fa-loading"></i>Progress ..</button>'
                     );
                 
                 @else
                 @endif
                 $(function() {
                     $('.pmanfaatupload_{{ $n . $idfilenya }}').on('click', function(e) {
                         e.preventDefault();
                         $('#formmodal').modal('show');

                         var url_upload =
                             '{{ Url('filemanager/dialog.php') }}?field_id={{ _('fpmanfaat' . $n . $idfilenya) }}&lang=en_EN&akey=@filemanager_get_key()&fldr=/';

                         $('.modal-body').html(
                             '<iframe style="width: 100%; height:400px; border: none" src="' +
                             url_upload + '"></iframe>');
                     });
                 });

                 function responsive_filemanager_callback(field_id) {
                     var url = jQuery('#' + field_id).val();
                     $('.' + field_id).html('<a href="' + url +
                         '" class="btn btn-info btn-md" target="_blank"><i class="fa fa-check"></i>Detail File</a>');
                 }
             </script>
         @endforeach
         @php
             $n++;
         @endphp
     @endforeach
 </div>
 {{-- peserta --}}
 @php
     $f = 1;
 @endphp
 @foreach ($parcipcant_docs as $documents)
     @php
         $document_id = $documents['id_par']['val'];
     @endphp
     <script type="text/javascript">
         $(function() {
             @if ($documents['nama_file']['val'] == '')
                 $('.peserta{{ $document_id }}').html(
                 '<button class="btn btn-warning btn-md"><i class="fa fa-loading"></i>Progress ..</button>'
                 );
             @else
             @endif


             $('.participant{{ $document_id }}').on('click', function(e) {
                 e.preventDefault();
                 $('#formmodal').modal('show');
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
                 '" class="btn btn-success btn-md" target="_blank"><i class="fa fa-check"></i>Detail File</a>');
         }
     </script>

     @php
         $f++;
     @endphp
 @endforeach


 @section('script')




     <!-- Modal -->
     <div class="modal fade" id="formmodal" role="dialog" aria-hidden="true">
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
