<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="@yield('meta_description', 'Trunçgil Teknoloji')">
  <meta name="author" content="Trunçgil Teknoloji">
  <title>@yield('title', 'Trunçgil Teknoloji')</title>
  <link rel="shortcut icon" href="{{ asset('html/assets/img/favicon.png') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('html/assets/fonts/unicons/unicons.css') }}">
  <link rel="stylesheet" href="{{ asset('html/assets/css/plugins.css') }}">
  <link rel="stylesheet" href="{{ asset('html/style.css') }}">
  <link rel="stylesheet" href="{{ asset('html/assets/css/colors/grape.css') }}">
  <link rel="preload" href="{{ asset('html/assets/css/fonts/urbanist.css') }}" as="style" onload="this.rel='stylesheet'">
  @stack('styles')
  <style>
    .navbar.navbar-light.fixed .btn:not(.btn-expand):not(.btn-gradient) {
        background: #e31e24 !important;
        border-color: #e31e24 !important;
        color: #ffffff !important;
    }
    @media (max-width: 991.98px){
      .navbar-expand-lg .navbar-collapse .dropdown-toggle:after {
        color: #ffffff !important;
      }
    }
  </style>
</head>

<body>
  <div class="grow shrink-0">
    <x-front.header />
    
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <x-front.footer />
  
  <!-- progress wrapper -->
  <div class="progress-wrap fixed w-[2.3rem] h-[2.3rem] cursor-pointer block shadow-[inset_0_0_0_0.1rem_rgba(128,130,134,0.25)] z-[1010] opacity-0 invisible translate-y-3 transition-all duration-[0.2s] ease-[linear,margin-right] delay-[0s] rounded-[100%] right-6 bottom-6 motion-reduce:transition-none after:absolute after:content-['\e951'] after:text-center after:leading-[2.3rem] after:text-[1.2rem] after:!text-[#e31e24] after:h-[2.3rem] after:w-[2.3rem] after:cursor-pointer after:block after:z-[1] after:transition-all after:duration-[0.2s] after:ease-linear after:left-0 after:top-0 motion-reduce:after:transition-none after:font-Unicons">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path class="fill-none stroke-[#e31e24] stroke-[4] box-border transition-all duration-[0.2s] ease-linear motion-reduce:transition-none" d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
  </div>

  <script src="{{ asset('html/assets/js/plugins.js') }}"></script>
  <script src="{{ asset('html/assets/js/theme.js') }}"></script>
  @stack('scripts')
</body>
</html>

