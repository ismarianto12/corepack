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
