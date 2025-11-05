<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ setting('seo_meta_title') }} - {{ $meta['title'] ?? ($settings->default_meta_title ?? config('app.name')) }}</title>
	<meta name="description" content="{{ $meta['description'] ?? ($settings->default_meta_description ?? '') }}">
	<link rel="icon" href="{{ $settings?->favicon_path ? asset($settings->favicon_path) : asset('assets/img/favicon.ico') }}">
	<link rel="stylesheet" href="{{ asset('html/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/unicons/unicons.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/colors/grape.css') }}">
	<link rel="preload" href="{{ asset('assets/css/fonts/urbanist.css') }}" as="style" onload="this.rel='stylesheet'">



</head>
<body>
	{{-- Dynamic Header Template or Static Navbar --}}
	@if(isset($renderedHeader) && $renderedHeader)
		{!! $renderedHeader !!}
	@else
		@include('partials.navbar')
	@endif

	{{-- Main Content --}}
	@yield('content')

	{{-- Dynamic Footer Template or Static Footer --}}
	@if(isset($renderedFooter) && $renderedFooter)
		{!! $renderedFooter !!}
	@else
		@include('partials.footer')
	@endif

	<script src="{{ asset('assets/js/plugins.js') }}"></script>
	<script src="{{ asset('assets/js/theme.js') }}"></script>
</body>
</html>


