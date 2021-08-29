var pmanfaat = new Dropzone('#file_upload_penerimamanfaat', {
    url: "{{ route('uploaddankelengkapan.lengkapi', $id) }}",
    autoProcessQueue: true,
    parallelUploads: 8, //maksimal jumlah upload
    uploadMultiple: false,
    maxFilesize: 2, //ukuran file 2MB
    addRemoveLinks: true,
    acceptedFiles: 'image/jpeg,image/png,image/jpg',
    params: {
        parameter: "file_upload_penerimamanfaat",
        no_aplikasi: '{{ $no_aplikasi }}',

    },
    init: function() {
        thisDropzone = this;
        this.on("uploadprogress", function(file, progress) {
            console.log("File progress", progress);
        });
        this.on("complete", function(file) {
            //pesan jika upload success
        });
        //menampilkan file dari database menggunakan ajax
        $.get('read.php', {
            id: '0'
        }, function(data) {
            $.each(data, function(key, value) {
                var mockFile = {
                    name: value.name,
                    size: value.size,
                    id: value.id
                };
                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                thisDropzone.options.thumbnail.call(thisDropzone, mockFile,
                    "images/" + value.name);

            });
        });

    },
    //Menghapus file dari database menggunakan ajax
    removedfile: function(file) {
        var name = file.name;
        var id = file.id;
        if (confirm("Are you sure want to delete?")) {
            $.ajax({
                type: 'POST',
                url: 'delete.php',
                data: {
                    id: id,
                    name: name
                },
                sucess: function(data) {
                    console.log('success: ' + data);
                    alert('Gambar telah di dihapus');
                }
            });
            var ref;
            if ((ref = file.previewElement) != null) {
                return ref.parentNode.removeChild(file.previewElement);

            }
            return false;
        }
    },
});


// $(function() {
    //     $('.filenya').on('change', function() {
    //         var data = new FormData();
    //         var id = $(this).attr('id');

    //         data.append('file', $(this).prop('files')[0]);
    //         data.append('no_aplikasi', '{{ $no_aplikasi }}');
    //         data.append('tmparameter_doc_id', id);


    //         var ext = $(this).val().split('.').pop().toLowerCase();
    //         if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
    //             swal.fire('Error',
    //                 'Jenis file tidak valid, pastikan extensi yang bisa di terima adalah gif, png, jpg, jpeg',
    //                 'error');
    //         } else {
    //             $(this).val('');
    //             $.ajax({

    //                 type: 'POST',
    //                 url: '{{ route('dokumenjaminan.uploaddata', $no_aplikasi) }}',
    //                 data: data,
    //                 contentType: false,
    //                 cache: false,
    //                 processData: false,
    //                 error: function(data) {
    //                     $(this).val('');
    //                     err = '';
    //                     respon = data.responseJSON;
    //                     $.each(respon.errors, function(index, value) {
    //                         err += "<li>" + value + "</li>";
    //                     });
    //                     swal.fire('Error',
    //                         err,
    //                         'error');
    //                 },
    //                 success: function(data) {
    //                     $(this).hide();
    //                     if (data.upload == 1) {
    //                         document.getElementById(id).setAttribute('disabled', true);
    //                         swal.fire('susccess', 'File berhasil di upload',
    //                             'success');
    //                         document.getElementById('view_' + id).innerHTML =
    //                             '<a href="' + data.filenya +
    //                             '" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i>Lihat</a><br />' +
    //                             '<a href="#" onclick="hapus_file(\'' + id +
    //                             '\')" data-id="' + data.filenya +
    //                             '" class="btn btn-warning btn-sm"><i class="fa fa-trash">Delete</a>';
    //                     } else {
    //                         swal.fire('error', 'File gagal di upload',
    //                             'error');
    //                         document.getElementById('view_' + id).innerHTML =
    //                             "Gagal di upload";
    //                     }
    //                 }
    //             });
    //         }
    //     });
    //     // delete function access 
    // });

    // function hapus_file(n) {
    //     event.preventDefault();
    //     $.confirm({
    //         title: '',
    //         content: 'Apakah Anda yakin akan menghapus file ini?',
    //         icon: 'fas fa-trash',
    //         theme: 'modern',
    //         closeIcon: true,
    //         animation: 'scale',
    //         type: 'red',
    //         buttons: {
    //             ok: {
    //                 text: 'ok!',
    //                 btnClass: 'btn btn-primary',
    //                 keys: ['enter'],
    //                 action: function() {
    //                     var id = $(this).attr('data-id');
    //                     $.post(
    //                         '{{ route('dokumenjaminan.delete_file', $no_aplikasi) }}', {
    //                             id: n
    //                         },
    //                         function(data) {
    //                             document.getElementById(n).removeAttribute('disabled');
    //                             document.getElementById('view_' + n).innerHTML = 'Berhasil di hapus';
    //                             swal.fire('susccess', 'File berhasil di upload',
    //                                 'success');
    //                         }
    //                     );
    //                 }
    //             },
    //             cancel: function() {}
    //         }
    //     });
    // }