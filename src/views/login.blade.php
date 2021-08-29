<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login</title>
    <link href="{{ pkg_asset('dash', 'dependencies/bootstrap/css/bootstrap-4.5.0.min.css') }}" rel="stylesheet">
    <link href="{{ pkg_asset('dash', 'dependencies/Font-Awesome/css/all.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ pkg_asset('dash', 'dependencies/jquery/jquery-3.5.1.min.js') }}"></script>
    <link href="{{ pkg_asset('dash', 'dependencies/stisla/css/style.css') }}" rel="stylesheet">
    <link href="{{ pkg_asset('dash', 'dependencies/stisla/css/components.css') }}" rel="stylesheet">
    <link href="{{ pkg_asset('dash', 'css/custom.css') }}" rel="stylesheet">
    <link href="{{ pkg_asset('dash', 'css/sb-admin-2.css') }}" rel="stylesheet">
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>

<body style="
background: url('{{ pkg_asset('ismarianto', 'assets/img/background.jpg') }}');
background-size: cover;
">
    <div id="app">
        <div id="pjax-container">
            <section class="section">
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <div class="card card-primary">
                                    <div class="card-body">
                                        <div class="login-brand">
                                            <img src="{{ pkg_asset('ismarianto', 'assets/img/logo_pbs.png') }}"
                                                alt="logo" width="200">
                                        </div>
                                        <form id="login" method="POST" class="needs-validation" novalidate="">


                                            <div class="form-group">
                                                <label for="text">Username</label>
                                                <input id="text" type="text"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    name="username" tabindex="1" required>

                                                <div class="invalid-feedback">
                                                    Username tidak boleh kosong
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <div class="d-block">
                                                    <label for="password" class="control-label">Password</label>
                                                    <div class="float-right">
                                                        {{-- <a href="auth-forgot-password.html" class="text-small">
                                                            Forgot Password?
                                                        </a> --}}
                                                    </div>
                                                </div>
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" tabindex="1" required>
                                                <div class="invalid-feedback">
                                                    Password tidak boleh kosong
                                                </div>
                                                @error('password') <div class="invalid-feedback">
                                                        {{ $errors->first() }}
                                                    </div>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-lg btn-block"
                                                    tabindex="4">
                                                    Login
                                                </button>
                                            </div>
                                        </form>
                                        @if (Session::has('message'))
                                            {!! session('message') !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h2 class="section-title" style="color: #ffff">Aplikasi Tabungan ZAM - ZAM
                                    {{ date('Y') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>

    <script>
        (function() {
            'use strict';
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });

        })();
        $(function() {
            $('#login').on('submit', function(e) {
                e.preventDefault();
                $('button').addClass('btn disabled btn-progress');
                if ($(this)[0].checkValidity() === false) {
                    e.preventDefault();
                    e.stopPropagation();
                    $('button').removeClass(
                        'disabled btn-progress');
                } else {
                    e.preventDefault();
                    $(this).removeClass('was-validated');
                    $.ajax({
                        url: "{{ route('actionlogin') }}",
                        method: 'post',
                        data: $(this).serialize(),
                        chace: false,
                        asynch: false,
                        success: function(data) {
                            $('input').attr('readonly', true);
                            if (data.status == 2) {
                                $('input').removeAttr('readonly', '');
                                $('button').removeClass(
                                    'disabled btn-progress');
                                $('form #login').addClass('');
                                $('input').addClass('is-invalid');
                                $('.invalid-feedback').html('<center>' + data.msg +
                                    '</center>');
                            } else {
                                $('input').removeClass('is-invalid');
                                $('.invalid-feedback').html(
                                    '<center>login berhasil sedang mengalihkan ....</center>'
                                );
                                window.location.href = '{{ route('dashboard') }}';
                            }
                        },
                        error: function(data, JqXHR) {
                            // alert(data, JqXHR)

                        }
                    })
                }
            });

        });
    </script>
</body>

</html>
