 <div class="row">
     <div class="col-12">
         <div class="card">
             <div class="card-header">
                 <h4>{{ _('Edit Modul Ismarianto') }}</h4>
             </div>
             <form id="exampleValidation" method="POST" class="simpan">
                 <div class="card-body p-0">
                     <div class="form-group row">

                         <label for="name" class="col-md-2 text-left">Nama Menu</label>
                         <div class="col-md-4">
                             <input type="text" class="form-control" id="" name="nama_menu" value="{{ $nama_menu }}">
                         </div>

                         <label for="name" class="col-md-2 text-left">Icon</label>
                         <div class="col-md-4">
                             <select class="form-control" name="icon">
                                 @foreach ($font as $fonts => $f)
                                     <option value="fa {{ $fonts }}"><i class="fa fa{{ $fonts }}"></i>
                                         fa {{ $fonts }}
                                     </option>
                                 @endforeach
                             </select>
                         </div>
                     </div>
                     <div class="form-group row">
                         <label for="name" class="col-md-2 text-left">Route</label>
                         <div class="col-md-4">
                             <select name="link" class="form-control select2">
                                 <option value="#">Default Page</option>
                                 @foreach (Route::getRoutes() as $route)
                                     @php
                                         $pilih = $link == $route->getName() ? 'selected' : '';
                                     @endphp
                                     <option value="{{ $route->getName() }}" {{ $pilih }}>
                                         {{ $route->getName() }}
                                     </option>
                                 @endforeach
                             </select>
                         </div>

                         <label for="name" class="col-md-2 text-left">Status AKtif</label>
                         <div class="col-md-4">
                             <select name="status" id="aktif" class="form-control">
                                 <option value="1">Aktif</option>
                                 <option value="2">Non Aktif</option>
                             </select>
                         </div>
                     </div>
                     <div class="form-group row">
                         <label for="name" class="col-md-2 text-left">Urutan</label>
                         <div class="col-md-4">
                             <select name="urutan" class="form-control">
                                 @for ($j = 1; $j <= 20; $j++)
                                     @php
                                         $selected = $j == $urutan ? 'selected' : '';
                                     @endphp
                                     <option value="{{ $j }}" {{ $selected }}>{{ $j }}
                                     </option>
                                 @endfor
                             </select>
                         </div>
                         <label for="name" class="col-md-2 text-left">Level akses</label>
                         <div class="col-md-4">
                             <select class="form-control select2" multiple="multiple" name="level_akses[]"
                                 style="width: 100%">
                                 @foreach ($level as $levels)
                                     @php
                                         if (strpos($level_akses, $levels->levelname) === false) {
                                             $selected = '';
                                         } else {
                                             $selected = 'selected';
                                         }
                                     @endphp
                                     <option value="{{ $levels->levelname }}" {{ $selected }}>
                                         {{ ucfirst($levels->levelname) }}
                                     </option>
                                 @endforeach
                             </select>
                         </div>

                     </div>

                 </div>
                 <div class="card-footer text-right">
                     <button class="btn btn-primary mr-1" type="submit">Submit</button>
                     <button class="btn btn-secondary" type="reset">Reset</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <script type="text/javascript">
     $(function() {
         $('.select2').select2();

         $('.simpan').on('submit', function(e) {
             e.preventDefault();
             // alert('asa');
             $.ajax({
                 url: "{{ route('modul.update', $id) }}",
                 method: "PUT",
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
         $('#level_akses_add').select2();

     });
     $(document).ready(function() {
         $('.js-example-basic-single').select2({
             width: '100%'
         });
     });
 </script>
