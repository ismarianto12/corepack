<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>{{ _('Tambah data submenu') }}</h4>
            </div>
            <form id="exampleValidation" method="POST" class="simpan">

                <div class="card-body p-0">
                    <div class="form-group row">
                        <label for="name" class="col-md-2 text-left">Induk Menu</label>
                        <div class="col-md-4">
                            <select name="id_parent" class="form-control">
                                @foreach ($parent as $parents)
                                    <option value="{{ $parents->id }}"> {{ $parents->nama_menu }} </option>
                                @endforeach
                            </select>
                        </div>
                        <label for="name" class="col-md-2 text-left">Nama Sub Menu</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-md-2 text-left">Icon Menu</label>
                        <div class="col-md-4">
                            <select class="form-control" name="icon">
                                @foreach ($font as $fonts => $f)
                                    <option value="fa {{ $fonts }}"><i class="fa fa{{ $fonts }}"></i>
                                        fa {{ $fonts }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label for="name" class="col-md-2 text-left">link</label>
                        <div class="col-md-4">
                            <select name="link" id="select2" class="form-control select2">
                                <option value="#">Default Page</option>
                                @foreach (Route::getRoutes() as $route)
                                    <option value="{{ $route->getName() }}">
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

                        <label for="name" class="col-md-2 text-left">Urutan</label>
                        <div class="col-md-4">
                            <select name="urutan" class="form-control">
                                @for ($j = 1; $j <= 20; $j++)
                                    <option value="{{ $j }}">{{ $j }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-md-2 text-left">level</label>
                        <div class="col-md-4">
                            <select id="level_akses_add" class="form-control" name="level_akses[]" multiple="multiple"
                                required>
                                @foreach ($level as $levels)
                                    <option value="{{ strtolower($levels->levelname) }}">
                                        {{ $levels->levelname }}
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
                url: "{{ route('submodul.store') }}",
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

        $('.select2').select2();

    });
</script>
