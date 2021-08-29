 <div class="row">
     <div class="col-12">
         <section class="section">
             <div class="card">
                 <div class="card-header">
                     <h4 class="sectionn-header">{{ _('Tambah data Parameter Document') }}</h4>
                 </div>
                 <form id="exampleValidation" method="POST" class="simpan">
                     <div class="form-group row">
                         <label for="name" class="col-md-2 text-left">Nama Document</label>
                         <div class="col-md-4">
                             <input type="text" name="nama_doc" class="form-control" required>
                         </div>
                         <label for="name" class="col-md-2 text-left">Peruntukan</label>
                         <div class="col-md-4">
                             <select class="select2 form-control" name="kode">
                                 @php
                                     $data = [
                                         'peserta' => 'Peserta',
                                         'pmanfaat' => 'Penerima Manfaat',
                                     ];
                                 @endphp

                                 @foreach ($data as $cat => $keys)
                                     <option value="{{ $cat }} ">{{ $keys }}</option>
                                 @endforeach
                             </select>
                         </div>
                     </div>

                     <div class="form-group row">
                         <label for="name" class="col-md-2 text-left">Jenis Hadiah</label>
                         <div class="col-md-4">
                             <select class="form-control select2" name="tmhadiah_id">
                                 @foreach ($tmhadiah as $tmhadiahs)
                                     <option value="{{ $tmhadiahs->id }} ">{{ $tmhadiahs->jenis_hadiah }} </option>
                                 @endforeach
                             </select>
                         </div>
                         <label for="name" class="col-md-2 text-left">Parmaeter Program</label>
                         <div class="col-md-4">
                             <select class="form-control select2" name="tmparameter_id">
                                 @foreach ($tmparameter as $parameters)
                                     <option value="{{ $parameters->id }} ">{{ $parameters->kode_prog }} -
                                         [{{ $parameters->nama_prog }}]</option>
                                 @endforeach
                             </select>
                         </div>
                     </div>
                     <div class="form-group row">
                         <label for="name" class="col-md-2 text-left">Kategory</label>
                         <div class="col-md-4">
                             <select class="select2 form-control" name="category">
                                 @php
                                     $data = [
                                         'jaminan' => 'Document Kelengkapan',
                                         'document' => 'Document Jaminan',
                                     ];
                                 @endphp

                                 @foreach ($data as $cat => $keys)
                                     <option value="{{ $cat }} ">{{ $keys }}</option>
                                 @endforeach
                             </select>
                         </div>
                         <label for="name" class="col-md-2 text-left">Status Document</label>
                         <div class="col-md-4">
                             <select class="select2 form-control" name="status">
                                 @php
                                     $doc = [
                                         'Wajib' => 'wajib',
                                         'tentatif' => 'Tentatif',
                                     ];
                                 @endphp
                                 @foreach ($doc as $props => $peys)
                                     <option value="{{ $props }} ">{{ $peys }}</option>
                                 @endforeach
                             </select>
                         </div>
                     </div>
                     <div class="card-footer text-right">
                         <button class="btn btn-primary mr-1" type="submit"><i class="fas fa-save"></i>Simpan</button>
                         <button class="btn btn-secondary" type="reset">Reset</button>
                     </div>
                 </form>
             </div>

         </section>
     </div>
 </div>


 <script type="text/javascript">
     $(function() {
         $('.simpan').on('submit', function(e) {
             e.preventDefault();
             // alert('asa');
             $.ajax({
                 url: "{{ route('trparameter_doc.store') }}",
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
                         title: 'Data berhasil di simpan',
                         showConfirmButton: false,
                         timer: 1500
                     })
                 },
                 error: function(data) {
                     var div = $('#container');
                     setInterval(function() {
                         var pos = div.scrollTop();
                         div.scrollTop(pos + 2);
                     }, 10)
                     err = '';
                     respon = data.responseJSON;
                     $.each(respon.errors, function(index, value) {
                         err += "<li>" + value + "</li>";
                     });
                     //  $('.ket').html(
                     //      "<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Perahtian donk!</strong> " +
                     //      respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                     $.notify({
                         icon: 'flaticon-alarm-1',
                         title: 'Opp Seperti nya lupa inputan berikut :',
                         message: err,
                     }, {
                         type: 'secondary',
                         placement: {
                             from: "top",
                             align: "right"
                         },
                         time: 3000,
                         z_index: 2000
                     });

                 }
             })
         });
     });
     $(document).ready(function() {
         $('.js-example-basic-single').select2({
             width: '100%'
         });

         $('#tmparmeter_id').on('change', function() {
             // get detail parameter 

         });

     });
 </script>
