     <div class="row">
         <div class="col-12">
             <div class="card">
                 <div class="card-header">
                     <h4>{{ _('Edit Sub Menu') }}</h4>
                 </div>
                 <form id="exampleValidation" method="POST" class="simpan" enctype="multipart/form-data">
                     <div class="card-body p-0">
                         <div class="form-group row">
                             <label for="name" class="col-md-2 text-left">Induk Menu</label>
                             <div class="col-md-4">
                                 <select name="id_parent" class="form-control">
                                     @foreach ($parent as $parents)
                                         @php
                                             $selected = $parents->id == $id_parent ? 'selected' : '';
                                         @endphp
                                         <option value="{{ $parents->id }}" {{ $selected }}>
                                             {{ $parents->nama_menu }} </option>
                                     @endforeach
                                 </select>
                             </div>
                             <label for="name" class="col-md-2 text-left">Nama Menu</label>
                             <div class="col-md-4">
                                 <input type="text" class="form-control" id="nama_menu" name="nama_menu"
                                     value="{{ $nama_menu }}">
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="name" class="col-md-2 text-left">Icon Menu</label>
                             <div class="col-md-4">
                                 <select class="form-control" name="font">
                                     @foreach ($font as $fonts)
                                         <option value="{{ $fonts }}"><i class="{{ $fonts }}"></i>
                                             {{ $fonts }}</option>

                                     @endforeach
                                 </select>
                             </div>

                             <label for="name" class="col-md-2 text-left">link</label>
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
                         </div>
                         <div class="form-group row">
                             <label for="name" class="col-md-2 text-left">Aktif</label>
                             <div class="col-md-4">
                                 <select name="status" id="aktif" class="form-control">
                                     <option value="1">Aktif</option>
                                     <option value="2">Non Aktif</option>
                                 </select>
                             </div>

                             <label for="name" class="col-md-2 text-left">urutan</label>
                             <div class="col-md-4">
                                 <select id="urutan" class="form-control select2" name="urutan">
                                     @for ($a = 1; $a <= 20; $a++)
                                         @php
                                             $pilih = $a == $urutan ? 'selected' : '';
                                         @endphp
                                         <option value="{{ $a }}" {{ $pilih }}>{{ $a }}
                                         </option>
                                     @endfor
                                 </select>
                             </div>
                         </div>
                         <div class="form-group row">
                             <label for="name" class="col-md-2 text-left">Level Akses</label>
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
             $('.simpan').on('submit', function(e) {
                 e.preventDefault();
                 // alert('asa');
                 $.ajax({
                     url: "{{ route('submodul.update', $id) }}",
                     method: "PUT",
                     data: $(this).serialize(),
                     chace: false,
                     async: false,
                     success: function(data) {
                         //  conlose.log($(this).serialize());
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
             $('.select2').select2();

         });
     </script>
