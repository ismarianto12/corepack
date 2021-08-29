@extends('tazamcore::layouts.template')

@section('content')
    {{-- pending case --}}
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <form method="post" class="needs-validation" novalidate="">
                <div class="card-header">
                    <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            <label>Username</label>
                            <input type="email" class="form-control" value="{!! Session::get('username') !!}" disabled>
                            <small>Username tidak dapat di ganti jika ada perubahan pada username silahkan hubungi help
                                deks</small>
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Nama</label>
                            <input type="email" class="form-control" value="{!! Session::get('username') !!}" disabled>
                            <small>Username tidak dapat di ganti jika ada perubahan pada username silahkan hubungi help
                                deks</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            <label>Password Lama</label>
                            <input type="text" class="form-control" name="pass_lama" required="">
                            <div class="invalid-feedback" id="pass_lama">
                                Password lama wajib di isi
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Password Baru</label>
                            <input type="text" class="form-control" name="pass_baru" required="">
                            <div class="invalid-feedback" id="pass_baru">
                                Password Baru Wajib di isi
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            <label>Ulangi Password</label>
                            <input type="email" class="form-control" name="repeat_password" value="" required="">
                            <div class="invalid-feedback" id="ulangi_pass">
                                Ulangi Password wajib di isi
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function() {
            var pass_lama = $('input[name="pass_lama"]').val();
            var pass_baru = $('input[name="pass_baru"]').val();
            var repeat_password = $('input[name="repeat_password"]').val();
            if (pass_lama != pass_baru) {


            } else {
                $.ajax({
                    url: '{{ route('user.actionsave') }}',
                    method: 'POST',
                    data: $(this).serialize();
                    chace: false,
                    asych: false,

                    succcess: function(data) {

                    },
                    error: function(data) {

                    }

                });

            }


        });
    </script>
@endsection

{{-- action save --}}
