 <div class="card-body p-0">
     <div class="table-responsive">
         <h3 class="section-title">Detail file nasabah yang sudah di upload</h3>

         <table class="table table-bordered" id="sortable-table">
             <tr>
                 <th>No.</th>
                 <th>Nama Doc.</th>
                 <th>Detail</th>
                 <th>Action</th>

             </tr>
             @php
                 $j = 1;
             @endphp
             @if ($data->count() > 0)
                 @foreach ($data->get() as $datas)
                     <tr>
                         <td>{{ $j }}</td>
                         <td>{{ $datas->nama_doc ? $datas->nama_doc : 'Data kosong' }}</td>
                         <td><a href="{{ asset('uploads/document/file_upload_nasabah/' . $datas->nama_file) }}"
                                 class="btn btn-primary btn-sm" target="_blank"><i class="fas fa-download"></i>
                                 Data</a>
                         </td>
                         <td><a href="#" class="btn btn-danger" onclick="javascript:hapus_doc({{ $datas->id }})"><i
                                     class="fas fa-trash"></i>Delete</a></td>
                     </tr>
                     @php
                         $j++;
                     @endphp
                 @endforeach
             @else
                 <tr>
                     <td colspan="4">Belum ada file yang di upload</td>
                 </tr>
             @endif

         </table>
     </div>
 </div>

 <script>
     function hapus_doc(id) {

         Swal.fire({
             title: 'Are you sure?',
             text: "You won't be able to revert this!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes, delete it!'
         }).then((result) => {
             if (result.isConfirmed) {
                 $.post('{{ route('uploaddankelengkapan.delete_file') }}', {
                     id_file: id,
                     parameter: 'file_upload_nasabah',
                 }, function(data) {
                     Swal.fire(
                         'Deleted!',
                         'File berhasil di hapus.',
                         'success'
                     );
                     $.post('{{ route('uploaddankelengkapan.table_file_nasabah') }}', {
                         no_aplikasi: {{ $no_aplikasi }},
                         status: 'nasabah',
                     }, function(data) {
                         $('#table_file_nasabah').html(data);
                     });
                 }).fail(function(jqXHR, textStatus, error) {
                     console.log("Post error: " + error);
                 });

             }
         })
     }
 </script>
