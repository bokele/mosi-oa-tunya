<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('page-ttile') {{ config('app.name', 'Laravel') }}</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">


</head>

<body>

    <!-- ======= Top Bar ======= -->
    <section id="topbar" class="d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <i class="bi bi-envelope d-flex align-items-center"><a
                        href="mailto:{{ !empty($setting->email) ? $setting->email : '' }}">{{ !empty($setting->email) ? $setting->email: '' }}</a></i>
                <i
                    class="bi bi-phone d-flex align-items-center ms-4"><span>{{ !empty($setting->mobile_phone) ? $setting->mobile_phone : '' }}</span></i>
                <i
                    class="bi bi-phone d-flex align-items-center ms-4"><span>{{ !empty($setting->hand_phone_number) ? $setting->hand_phone_number : ''  }}</span></i>
            </div>
            <div class="social-links d-none d-md-flex align-items-center">
                <a href="{{ !empty($setting->twitter_url) ? $setting->twitter_url : '' }}" class="twitter"><i
                        class="bi bi-twitter"></i></a>
                <a href="{{ !empty($setting->facebook_url) ? $setting->facebook_url : ''}}" class="facebook"><i
                        class="bi bi-facebook"></i></a>
                <a href="{{ !empty($setting->instagram_url ) ? $setting->instagram_url : '' }}" class="instagram"><i
                        class="bi bi-instagram"></i></a>
                {{-- <a href="{{ $setting->email }}" class="linkedin"><i class="bi bi-linkedin"></i></i></a> --}}
            </div>
        </div>
    </section>
    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">

            <h1 class="logo"><a href="index.html">BizLand<span>.</span></a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo"><img src="{{ asset('assets/img/logo.png') }}" alt=""></a>-->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="#about">About</a></li>
                    <li><a class="nav-link scrollto" href="#services">Services</a></li>
                    {{-- <li><a class="nav-link scrollto " href="{{route('common.dealbook') }} ">DayBook</a></li> --}}
                    <li><a class="nav-link scrollto" href="#team">Team</a></li>

                    <li><a class="nav-link scrollto" href="#contact">Contact</a></li>


                    @if (Route::has('login'))

                    @auth
                    @if (auth()->user()->is_superuser)
                    <li> <a href="{{ route('admin.dashboard') }}" class="text-muted nav-link scrollto">Dashboard</a>
                    </li>
                    @else
                    <li> <a href="{{ url('/dashboard') }}" class="text-muted nav-link scrollto">Dashboard</a></li>
                    @endif
                    @else
                    <li> <a href="{{ route('login') }}" class="text-muted nav-link scrollto">Log in</a></li>

                    @if (Route::has('register'))
                    <li> <a href="{{ route('register') }}" class="ml-4 text-muted nav-link scrollto">Register</a></li>
                    @endif
                    @endif

                    @endif


                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->
