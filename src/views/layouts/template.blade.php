   <!DOCTYPE html>
   <html lang="en">

   <head>
       <meta charset="UTF-8">
       <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
       <meta name="csrf-token" content="{{ csrf_token() }}" />

       <title>{{ $title }}</title>

       <link href="{{ pkg_asset('dash', 'dependencies/bootstrap/css/bootstrap-4.5.0.min.css') }}" rel="stylesheet">
       <link href="{{ pkg_asset('dash', 'dependencies/Font-Awesome/css/all.css') }}" rel="stylesheet" type="text/css">
       <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
       <link href="{{ pkg_asset('tazamcore', 'assets/css/style.css') }}" rel="stylesheet">
       <link href="{{ pkg_asset('dash', 'dependencies/stisla/css/components.css') }}" rel="stylesheet">
       <link href="{{ pkg_asset('dash', 'css/custom.css') }}" rel="stylesheet">
       <link href="{{ pkg_asset('tazamcore', 'assets/css/jquery-confirm.min.css') }}" rel="stylesheet">
       <script src="{{ pkg_asset('dash', 'dependencies/jquery/jquery-3.5.1.min.js') }}"></script>

       <script src="{{ pkg_asset('dash', 'dependencies/stisla/js/scripts.js') }}"></script>

       <link href="{{ pkg_asset('tazamcore', 'assets/plugin/select2/css/select2.min.css') }}" rel="stylesheet">
       <script src="{{ pkg_asset('tazamcore', 'assets/js/aplikasi.js') }}"></script>


       <script type="text/javascript">
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });
       </script>
       <link rel="stylesheet" type="text/css" href="{{ pkg_asset('tazamcore', 'assets/css/tooltipster.css') }}" />
       <script src="{{ pkg_asset('tazamcore', 'assets/js/jquery.tooltipster.min.js') }}">
       </script>
       <link href="{{ pkg_asset('tazamcore', 'assets/css') }}/red/pace-theme-flash.css" rel="stylesheet" />
       @yield('head')
   </head>

   <body>
       <div id="app">
           <div class="main-wrapper main-wrapper-1">
               <div class="navbar-bg"></div>
               <nav class=" navbar navbar-expand-lg main-navbar">
                   <form class=" form-inline mr-auto">
                       <ul class="navbar-nav mr-3">
                           <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                       class="fas fa-bars"></i></a>
                           </li>
                           <!-- <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li> -->
                       </ul>
                       <!--<div class="search-element">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        <div class="search-backdrop"></div>
                        <div class="search-result">
                            <div class="search-header">
                                Histories
                            </div>
                            <div class="search-item">
                                <a href="#">How to hack NASA using CSS</a>
                                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                            </div>
                            <div class="search-item">
                                <a href="#">Kodinger.com</a>
                                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                            </div>
                            <div class="search-item">
                                <a href="#">#Stisla</a>
                                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
                            </div>
                            <div class="search-header">
                                Result
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <img class="mr-3 rounded" width="30" src="../assets/img/products/product-3-50.png" alt="product">
                                    oPhone S9 Limited Edition
                                </a>
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <img class="mr-3 rounded" width="30" src="../assets/img/products/product-2-50.png" alt="product">
                                    Drone X2 New Gen-7
                                </a>
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <img class="mr-3 rounded" width="30" src="../assets/img/products/product-1-50.png" alt="product">
                                    Headphone Blitz
                                </a>
                            </div>
                            <div class="search-header">
                                Projects
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <div class="search-icon bg-danger text-white mr-3">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    Stisla Admin Template
                                </a>
                            </div>
                            <div class="search-item">
                                <a href="#">
                                    <div class="search-icon bg-primary text-white mr-3">
                                        <i class="fas fa-laptop"></i>
                                    </div>
                                    Create a new Homepage Design
                                </a>
                            </div>
                        </div>
                    </div> -->
                   </form>
                   <ul class="navbar-nav navbar-right">
                       @if (Tmparamtertr::session('role') == 'internalcontrol' || Tmparamtertr::session('role') == 'manageroperation' || Tmparamtertr::session('role') == 'businessdevelopment')
                           <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                                   class="nav-link notification-toggle nav-link-lg beep"><i
                                       class="far fa-envelope"></i></a>
                               <div class="dropdown-menu dropdown-list dropdown-menu-right">
                                   <div class="dropdown-header">Otorisasi
                                       <div class="float-right">
                                           <a href="#">Semua data otorisasi</a>
                                       </div>
                                   </div>
                                   <div id="otorisasi" class="dropdown-list-content dropdown-list-icons"
                                       style="overflow: auto">

                                   </div>
                                   <div class="dropdown-footer text-center">
                                       <a href="{{ route('otorisasi.index') }}">View All <i
                                               class="fas fa-chevron-right"></i></a>
                                   </div>
                               </div>
                           </li>

                           <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                                   class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                               <div class="dropdown-menu dropdown-list dropdown-menu-right">
                                   <div class="dropdown-header">Verifikasi
                                       <div class="float-right">
                                           <a href="#">Semua data verifikasi</a>
                                       </div>
                                   </div>
                                   <div id="verifikasi" class="dropdown-list-content dropdown-list-icons"
                                       style="overflow: auto">
                                   </div>
                                   <div class="dropdown-footer text-center">
                                       <a href="{{ route('verifikasikelengkapan.index') }}">View All <i
                                               class="fas fa-chevron-right"></i></a>
                                   </div>
                               </div>
                           </li>
                       @endif

                       <li class="dropdown">
                           @if (View::exists('main::layouts.parts.nav-user'))
                               @include('main::layouts.parts.nav-user')
                           @else
                               <a href="#" data-toggle="dropdown"
                                   class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                   <img alt="image"
                                       src="{{ pkg_asset('dash', 'dependencies/stisla/img/avatar/avatar-1.png') }}"
                                       class="rounded-circle mr-1">
                                   @php
                                       $cabang = Session::get('unit');
                                   @endphp

                                   @if (Tmparamtertr::session('role') == 'marketing' || Tmparamtertr::session('role') == 'manageroperation')

                                       <div class="d-sm-none d-lg-inline-block">
                                           {{ ucfirst(Session::get('username')) }} - Cabang
                                           [{{ $cabang }}-{{ Tmparamtertr::cabang($cabang) }} ]
                                       </div>

                                   @else

                                       <div class="d-sm-none d-lg-inline-block">Selamat datang,
                                           {{ ucfirst(Session::get('username')) }}
                                       </div>
                                   @endif

                               </a>
                               <div class="dropdown-menu dropdown-menu-right">

                                   <a href="{{ route('user.changepass') }}" onclick="$(this).parent().submit()"
                                       class="dropdown-item has-icon text-danger">
                                       <i class="fas fa-user"></i> Change Password
                                   </a>
                                   <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                       @csrf

                                       <a href="#" onclick="$(this).parent().submit()"
                                           class="dropdown-item has-icon text-danger">
                                           <i class="fas fa-sign-out-alt"></i> Logout
                                       </a>
                                   </form>
                               </div>
                           @endif
                       </li>
                   </ul>
               </nav>
               <!-- Sidebar -->
               <div class="main-sidebar">
                   <aside id="sidebar-wrapper">
                       <div class="sidebar-brand">
                           <a href="index.html">
                               <img src="{{ pkg_asset('tazamcore', 'assets/img/logo_pbs.png') }}" alt="logo"
                                   width="200">
                       </div>
                       <div class="sidebar-brand sidebar-brand-sm">
                           <a href="index.html">PDSB</a>
                       </div>
                       <ul class="sidebar-menu">
                           @php
                               $level = Tmparamtertr::session('role');
                           @endphp
                           {!! MenuApp::menu_app($level) !!}

                       </ul>
                       <!-- <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                        <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                            <i class="fas fa-rocket"></i> Documentation
                        </a>
                    </div> -->
                   </aside>
               </div>

               <!-- Main Content -->
               <div class="main-content">
                   <section class="section">
                       @include('tazamcore::layouts.breadcrumb', ['titledash' => $title])
                       {{-- @include('dash::components.messages') --}}
                       <div class="section-body">
                           @yield('content')
                       </div>

                       <!-- <div class="section-body">
                        <h2 class="section-title">This is Example Page</h2>
                        <p class="section-lead">This page is just an example for you to create your own page.</p>
                        <div class="card">
                            <div class="card-header">
                                <h4>Example Card</h4>
                            </div>
                            <div class="card-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            </div>
                            <div class="card-footer bg-whitesmoke">
                                This is card footer
                            </div>
                        </div>
                    </div> -->
                   </section>
               </div>
               <footer class="main-footer">
                   <div class="footer-left">
                       {{-- Copyright &copy; 2020 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad
                        Nauval Azhar</a> --}}
                   </div>
                   <div class="footer-right">
                       2.3.0
                   </div>
               </footer>
           </div>
       </div>

       @yield('script')

       <script src="{{ pkg_asset('tazamcore', 'assets/plugin/select2/js/select2.min.js') }}"></script>

       <script src="{{ pkg_asset('tazamcore', 'assets/js/jquery-confirm.min.js') }}"></script>
       <script src="{{ pkg_asset('dash', 'dependencies/popper/popper-2.4.0.min.js') }}"></script>
       <script src="{{ pkg_asset('dash', 'dependencies/bootstrap/js/bootstrap-4.5.0.min.js') }}"></script>
       <script src="{{ pkg_asset('dash', 'js/focus-menu.js') }}"></script>
       <script src="{{ pkg_asset('dash', 'dependencies/stisla/js/jquery.nicescroll.min.js') }}"></script>
       <script src="{{ pkg_asset('dash', 'dependencies/stisla/js/moment.min.js') }}"></script>
       <script src="{{ pkg_asset('dash', 'dependencies/stisla/js/stisla.js') }}"></script>
       <script src="{{ pkg_asset('tazamcore', 'assets') }}/js/pace.js"></script>
       {{-- otorisasi
       verifikasi
       jumlah --}}

       <script>
           function _otorisasicall() {
               $.ajax({
                   url: '{{ route('notifikasi.otorisasi') }}',
                   method: 'GET',
                   dataType: "json",
                   chace: false,
                   asynch: false,
                   success: function(data) {
                       nil = '';
                       $.each(data, function(index, value) {
                           nil +=
                               '<a href="{{ route('otorisasi.index') }}" class="dropdown-item dropdown-item-unread"><div class="dropdown-item-icon bg-primary text-white"><i class="fas fa-user"></i></div><div class="dropdown-item-desc">' +
                               value.no_aplikasi + '-' + value.nama_sesuai_ktp +
                               '<div class="time text-primary">' +
                               value.created_at +
                               '</div></div></a>';
                       });
                       $('#otorisasi').html(nil);
                   },
                   error: function(error, JqXhr) {
                       // swal.fire('error', 'access error' + JqXhr, 'error');
                   }
               });
           }

           function _verifikasicall() {
               $.ajax({
                   url: '{{ route('notifikasi.verifikasi') }}',
                   method: 'GET',
                   dataType: "json",
                   chace: false,
                   asynch: false,
                   success: function(data) {
                       nil = '';
                       $.each(data, function(index, f) {
                           nil +=
                               '<a href="{{ route('verifikasikelengkapan.index') }}" class="dropdown-item dropdown-item-unread"><div class="dropdown-item-icon bg-primary text-white"><i class="fas fa-users"></i></div><div class="dropdown-item-desc">' +
                               f.no_aplikasi + '-' + f.nama_sesuai_ktp +
                               '<div class="time text-primary">' +
                               f.created_at +
                               '</div></div></a>';
                       });
                       $('#verifikasi').html(nil);
                   },
                   error: function(error, JqXhr) {
                       // swal.fire('error', 'access error' + JqXhr, 'error');
                   }
               });
           }
           _otorisasicall();
           _verifikasicall();

           $(function() {
               $('.nav-link').on('click', function() {
                   _otorisasicall();
                   _verifikasicall();
               });
           });

           //create notification 
           Pace.start(
               paceOptions = {
                   ajax: false, // disabled
                   document: true, // enabled
                   eventLag: false, // disabled

               }
           );
       </script>

       <script src="{{ pkg_asset('dash', 'dependencies/stisla/js/custom.js') }}"></script>
       @yield('foot')
   </body>

   </html>
