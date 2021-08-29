<div class="card-body p-0">
    <div class="table-responsive">
        <h3 class="section-title">Detail file penerima manfaat yang sudah di upload</h3>

        <table class="table table-striped" id="sortable-table">
            <tr>
                <th>No.</th>
                <th>Nama Doc.</th>
                <th>Detail</th>
                <th>Action</th>

            </tr>
            @php
                $j = 1;
            @endphp
            @foreach ($data as $datas)
                <tr>
                    <td>{{ $j }}</td>
                    <td>{{ $datas->nama_doc ? $datas->nama_doc : 'Data kosong' }}</td>
                    <td><a href="{{ asset('uploads/document/file_upload_penerimamanfaat/' . $datas->no_aplikasi . '_' . $nama_penerima_manfaat . '/' . $datas->nama_file) }}"
                            class="btn btn-primary btn-sm" target="_blank"><i class="fas fa-download"></i>
                            Data</a>
                    </td>
                    <td><a href="#" class="btn btn-danger" onclick="return hapus_file({{ $datas->id }})"><i
                                class="fas fa-trash"></i>Delete</a></td>
                </tr>
                @php
                    $j++;
                @endphp
            @endforeach

        </table>
    </div>
</div>


<script>
    function hapus_file(n) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "File akan di hapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('{{ route('uploaddankelengkapan.delete_file') }}', {
                    id_file: n,
                    parameter: 'file_upload_penerimamanfaat',

                }, function(data) {
                    Swal.fire(
                        'Deleted!',
                        'File berhasil di hapus.',
                        'success'
                    );
                    $.post('{{ route('uploaddankelengkapan.table_file_penerima_manfaat') }}', {
                        no_aplikasi: '{{ $no_aplikasi }}',
                        status: 'penerimamanfaat',
                    }, function(data) {
                        $('#table_file_penerima_manfaat').html(data);
                    });
                }).fail(function(jqXHR, textStatus, error) {
                    console.log("Post error: " + error);
                });

            }
        })
    }
</script>
