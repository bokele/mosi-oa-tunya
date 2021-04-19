<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="description" content="{{ !empty($seo->meta_description) ? $seo->meta_description : '' }}">
    <meta name="keywords" content="{{ !empty($seo->meta_keywords) ? $seo->meta_keywords : '' }}">
    <meta name="author" content="{{ !empty($seo->meta_author) ? $seo->meta_author : '' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('page-title') {{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/dashboard.css') }}">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    @livewireStyles

    <!-- Scripts -->
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/dashboard.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed font-sans antialiased">
    <div class="wrapper">

        <!-- Navbar -->
        @livewire('navigation-menu')


        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-warning elevation-2">
            <!-- Brand Logo -->
            <a href="/" class="brand-link">
                <x-jet-application-mark width="36" class="brand-image img-circle elevation-1" style="opacity: .8" />
                <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="image">
                        <img src="{{ Auth::user()->profile_photo_url }}" class="img-circle elevation-1"
                            alt="{{ Auth::user()->full_name }}">
                    </div>
                    @endif
                    <div class="info">
                        <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->full_name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @if (auth()->user()->is_superuser)
                        @include('admin.adminSidebarMenu')

                        @endif

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">

                        {{ $header }}

                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            {{ $slot }}
                        </div>

                        @if (isset($aside))
                        <div class="col-lg-3">
                            {{ $aside }}
                        </div>
                        @endif
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">

                <strong>Powered by<a href="https://adminlte.io"> UVATECHNO</a></strong>
            </div>
            <strong>&copy; <a href="https://www.jacarandahub.org/">Jacaranda Hub</a></strong>
        </footer>
    </div>

    @stack('modals')
    @livewireScripts
    @stack('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
    {{-- <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script> --}}
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>


    <script>
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(document).ready(function() {
                    $('#summernote').summernote();
                    $('#description').summernote();
                    $('.select2').select2({
                    theme: 'bootstrap4'
                    });
                    $('.select2bs4').select2({
                    theme: 'bootstrap4'
                    });
                });
    </script>
    @stack('modals')
    @livewireScripts

    @stack('scripts')

    <script type='text/javascript'>
        @if (Session::has('message'))


                let type = "{{ Session::get('alert-type', 'info')}}";
                    switch (type) {
                        case 'success':
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: "{{ Session::get('message')}}",
                                showConfirmButton: false,
                                toast: true,
                                timer: 6000
                            });
                            break;

                        case 'error':
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: "{{ Session::get('message')}}"
                            })

                            break;

                            case 'info':
                            Swal.fire({
                            icon: 'info',
                            title: 'Information...',
                            text: "{{ Session::get('message') }} "
                            })

                            break;
                            case 'warning':
                            Swal.fire({
                            icon: 'warning',
                            title: 'Warning...',
                            text: "{{ Session::get('message') }}"

                         });
                         break;
                        }
                @endif

    </script>
</body>

</html>
