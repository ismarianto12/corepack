 <div class="row">
     <div class="col-12">
         <div class="card">
             <div class="card-header">
                 <h4>{{ _('Input data nasabah') }}</h4>
             </div>



             <form id="exampleValidation" method="POST" class="simpan">

                 <div class="p-5 bg-white rounded shadow mb-5">
                     <!-- Rounded tabs -->
                     <ul id="myTab" role="tablist"
                         class="nav nav-tabs nav-pills flex-column flex-sm-row text-center bg-light border-0 rounded-nav">
                         <li class="nav-item flex-sm-fill">
                             <a id="nasabah-tab" data-toggle="tab" href="#nasabah" role="tab" aria-controls="nasabah"
                                 aria-selected="true"
                                 class="nav-link border-0 text-uppercase font-weight-bold active">Data Ismarianto</a>
                         </li>
                         <li class="nav-item flex-sm-fill">
                             <a id="parameter-tab" data-toggle="tab" href="#parameter" role="tab"
                                 aria-controls="parameter" aria-selected="false"
                                 class="nav-link border-0 text-uppercase font-weight-bold">Parameter Program</a>
                         </li>
                         <li class="nav-item flex-sm-fill">
                             <a id="phadiah-tab" data-toggle="tab" href="#phadiah" role="tab" aria-controls="phadiah"
                                 aria-selected="false" class="nav-link border-0 text-uppercase font-weight-bold">Pilihan
                                 Hadiah</a>
                         </li>

                         <li class="nav-item flex-sm-fill">
                             <a id="slik-tab" data-toggle="tab" href="#slik" role="tab" aria-controls="slik"
                                 aria-selected="false" class="nav-link border-0 text-uppercase font-weight-bold">Proses
                                 Slik
                             </a>
                         </li>
                     </ul>
                     <div id="myTabContent" class="tab-content">
                         <form class="form-control">

                             <div id="nasabah" role="tabpanel" aria-labelledby="nasabah-tab"
                                 class="tab-pane fade px-4 py-5 show active">

                                 <div class="form-group row">
                                     <label for="id" class="col-md-2 text=left">id</label>
                                     <div class="col-md-4">
                                         <input type="text" name="id" class="form-control" id="id">
                                     </div>
                                     <label for="no_aplikasi" class="col-md-2 text=left">no_aplikasi</label>
                                     <div class="col-md-4">

                                         <input type="text" name="no_aplikasi" class="form-control" id="no_aplikasi">
                                     </div>
                                 </div>

                                 <div class="form-group row">

                                     <label for="no_ktp" class="col-md-2 text=left">no_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="no_ktp" class="form-control" id="no_ktp">
                                     </div>


                                     <label for="nama_sesuai_ktp" class="col-md-2 text=left">nama_sesuai_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="nama_sesuai_ktp" class="form-control"
                                             id="nama_sesuai_ktp">
                                     </div>
                                 </div>
                                 <div class="form-group row">

                                     <label for="tempat_lahir_ktp" class="col-md-2 text=left">tempat_lahir_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="tempat_lahir_ktp" class="form-control"
                                             id="tempat_lahir_ktp">
                                     </div>


                                     <label for="tanggal_lahir_ktp" class="col-md-2 text=left">tanggal_lahir_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="tanggal_lahir_ktp" class="form-control"
                                             id="tanggal_lahir_ktp">
                                     </div>
                                 </div>

                                 <div class="form-group row">

                                     <label for="jenis_kelamin_ktp" class="col-md-2 text=left">jenis_kelamin_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="jenis_kelamin_ktp" class="form-control"
                                             id="jenis_kelamin_ktp">
                                     </div>


                                     <label for="pekerjaan_ktp" class="col-md-2 text=left">pekerjaan_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="pekerjaan_ktp" class="form-control"
                                             id="pekerjaan_ktp">
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <label for="status_pernikahan_ktp"
                                         class="col-md-2 text=left">status_pernikahan_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="status_pernikahan_ktp" class="form-control"
                                             id="status_pernikahan_ktp">
                                     </div>


                                     <label for="alamat_sesuai_ktp" class="col-md-2 text=left">alamat_sesuai_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="alamat_sesuai_ktp" class="form-control"
                                             id="alamat_sesuai_ktp">
                                     </div>
                                 </div>
                                 <div class="form-group row">

                                     <label for="rt_rw_ktp" class="col-md-2 text=left">rt_rw_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="rt_rw_ktp" class="form-control" id="rt_rw_ktp">
                                     </div>


                                     <label for="kelurahan_ktp" class="col-md-2 text=left">kelurahan_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="kelurahan_ktp" class="form-control"
                                             id="kelurahan_ktp">
                                     </div>
                                 </div>
                                 <div class="form-group row">


                                     <label for="kecamatan_ktp" class="col-md-2 text=left">kecamatan_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="kecamatan_ktp" class="form-control"
                                             id="kecamatan_ktp">
                                     </div>


                                     <label for="kode_kota_kabupaten_ktp"
                                         class="col-md-2 text=left">kode_kota_kabupaten_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="kode_kota_kabupaten_ktp" class="form-control"
                                             id="kode_kota_kabupaten_ktp">
                                     </div>
                                 </div>

                                 <div class="form-group row">


                                     <label for="kota_kabupaten_ktp"
                                         class="col-md-2 text=left">kota_kabupaten_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="kota_kabupaten_ktp" class="form-control"
                                             id="kota_kabupaten_ktp">
                                     </div>


                                     <label for="kode_provinsi_ktp" class="col-md-2 text=left">kode_provinsi_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="kode_provinsi_ktp" class="form-control"
                                             id="kode_provinsi_ktp">
                                     </div>
                                 </div>
                                 <div class="form-group row">



                                     <label for="provinsi_ktp" class="col-md-2 text=left">provinsi_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="provinsi_ktp" class="form-control" id="provinsi_ktp">
                                     </div>


                                     <label for="kode_pos_ktp" class="col-md-2 text=left">kode_pos_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="kode_pos_ktp" class="form-control" id="kode_pos_ktp">
                                     </div>

                                 </div>
                                 <div class="form-group row">

                                     <label for="alamat_domisili" class="col-md-2 text=left">alamat_domisili</label>
                                     <div class="col-md-4">

                                         <input type="text" name="alamat_domisili" class="form-control"
                                             id="alamat_domisili">
                                     </div>


                                     <label for="rt_rw_domisili" class="col-md-2 text=left">rt_rw_domisili</label>
                                     <div class="col-md-4">

                                         <input type="text" name="rt_rw_domisili" class="form-control"
                                             id="rt_rw_domisili">
                                     </div>

                                 </div>

                                 <div class="form-group row">
                                     <label for="kelurahan_domisili"
                                         class="col-md-2 text=left">kelurahan_domisili</label>
                                     <div class="col-md-4">

                                         <input type="text" name="kelurahan_domisili" class="form-control"
                                             id="kelurahan_domisili">
                                     </div>


                                     <label for="kecamatan_domisili"
                                         class="col-md-2 text=left">kecamatan_domisili</label>
                                     <div class="col-md-4">
                                         <input type="text" name="kecamatan_domisili" class="form-control"
                                             id="kecamatan_domisili">

                                     </div>

                                 </div>

                                 <div class="form-group row">

                                     <label for="kota_kabupaten_domisili"
                                         class="col-md-2 text=left">kota_kabupaten_domisili</label>
                                     <div class="col-md-4">

                                         <input type="text" name="kota_kabupaten_domisili" class="form-control"
                                             id="kota_kabupaten_domisili">
                                     </div>


                                     <label for="provinsi_domisili" class="col-md-2 text=left">provinsi_domisili</label>
                                     <div class="col-md-4">

                                         <input type="text" name="provinsi_domisili" class="form-control"
                                             id="provinsi_domisili">
                                     </div>
                                 </div>
                                 <div class="form-group row">

                                     <label for="kode_pos_domisili" class="col-md-2 text=left">kode_pos_domisili</label>
                                     <div class="col-md-4">

                                         <input type="text" name="kode_pos_domisili" class="form-control"
                                             id="kode_pos_domisili">
                                     </div>


                                     <label for="jenis_penduduk" class="col-md-2 text=left">jenis_penduduk</label>
                                     <div class="col-md-4">

                                         <input type="text" name="jenis_penduduk" class="form-control"
                                             id="jenis_penduduk">
                                     </div>
                                 </div>
                                 <div class="form-group row">

                                     <label for="kewarganegaraan" class="col-md-2 text=left">kewarganegaraan</label>
                                     <div class="col-md-4">

                                         <input type="text" name="kewarganegaraan" class="form-control"
                                             id="kewarganegaraan">
                                     </div>


                                     <label for="nama_ibu_kandung_ktp"
                                         class="col-md-2 text=left">nama_ibu_kandung_ktp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="nama_ibu_kandung_ktp" class="form-control"
                                             id="nama_ibu_kandung_ktp">
                                     </div>
                                 </div>
                                 <div class="form-group row">

                                     <label for="agama" class="col-md-2 text=left">agama</label>
                                     <div class="col-md-4">

                                         <input type="text" name="agama" class="form-control" id="agama">
                                     </div>


                                     <label for="no_hp" class="col-md-2 text=left">no_hp</label>
                                     <div class="col-md-4">

                                         <input type="text" name="no_hp" class="form-control" id="no_hp">
                                     </div>
                                 </div>
                                 <div class="form-group row">

                                     <label for="email" class="col-md-2 text=left">email</label>
                                     <div class="col-md-4">

                                         <input type="text" name="email" class="form-control" id="email">
                                     </div>


                                     <label for="tlp_rumah" class="col-md-2 text=left">tlp_rumah</label>
                                     <div class="col-md-4">

                                         <input type="text" name="tlp_rumah" class="form-control" id="tlp_rumah">
                                     </div>
                                 </div>
                                 <div class="form-group row">

                                     <label for="penghasilan_perbulan"
                                         class="col-md-2 text=left">penghasilan_perbulan</label>
                                     <div class="col-md-4">

                                         <input type="text" name="penghasilan_perbulan" class="form-control"
                                             id="penghasilan_perbulan">
                                     </div>


                                     <label for="penghasilan_pertahun"
                                         class="col-md-2 text=left">penghasilan_pertahun</label>
                                     <div class="col-md-4">

                                         <input type="text" name="penghasilan_pertahun" class="form-control"
                                             id="penghasilan_pertahun">
                                     </div>
                                 </div>
                                 <div class="form-group row">

                                     <label for="pengeluaran_pertahun"
                                         class="col-md-2 text=left">pengeluaran_pertahun</label>
                                     <div class="col-md-4">

                                         <input type="text" name="pengeluaran_pertahun" class="form-control"
                                             id="pengeluaran_pertahun">
                                     </div>


                                     <label for="status_tempat_tinggal"
                                         class="col-md-2 text=left">status_tempat_tinggal</label>
                                     <div class="col-md-4">

                                         <input type="text" name="status_tempat_tinggal" class="form-control"
                                             id="status_tempat_tinggal">
                                     </div>
                                 </div>
                                 <div class="form-group row">

                                     <label for="jumlah_tanggungan" class="col-md-2 text=left">jumlah_tanggungan</label>
                                     <div class="col-md-4">

                                         <input type="text" name="jumlah_tanggungan" class="form-control"
                                             id="jumlah_tanggungan">
                                     </div>


                                     <label for="kategori_nasabah" class="col-md-2 text=left">kategori_nasabah</label>
                                     <div class="col-md-4">

                                         <input type="text" name="kategori_nasabah" class="form-control"
                                             id="kategori_nasabah">
                                     </div>
                                 </div>
                                 <div class="form-group row">

                                     <label for="tujuan_penggunaan" class="col-md-2 text=left">tujuan_penggunaan</label>
                                     <div class="col-md-4">
                                         <input type="text" name="tujuan_penggunaan" class="form-control"
                                             id="tujuan_penggunaan">
                                     </div>

                                     <label for="nama_kelurahan" class="col-md-2 text=left">nama_kelurahan</label>
                                     <div class="col-md-4">
                                         <input type="text" name="nama_kelurahan" class="form-control"
                                             id="nama_kelurahan">
                                     </div>
                                 </div>
                                 <div class="form-group row">

                                     <label for="nominal_setor_tunai"
                                         class="col-md-2 text=left">nominal_setor_tunai</label>
                                     <div class="col-md-4">
                                         <input type="text" name="nominal_setor_tunai " class="form-control"
                                             id="nominal_setor_tunai">

                                     </div>
                                 </div>
                                 {{-- endstatement --}}
                             </div>
                             <div id="parameter" role="tabpanel" aria-labelledby="parameter-tab"
                                 class="tab-pane fade px-4 py-5">

                             </div>
                             <div id="phadiah" role="tabpanel" aria-labelledby="phadiah-tab"
                                 class="tab-pane fade px-4 py-5">

                             </div>

                             <div id="slik" role="tabpanel" aria-labelledby="slik-tab" class="tab-pane fade px-4 py-5">

                             </div>
                         </form>

                     </div>
                     <!-- End rounded tabs -->
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
                 url: "{{ route('nasabah.store') }}",
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
     });
 </script>
