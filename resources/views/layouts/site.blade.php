<?php 

$favicon_path = setting('site_favicon');
?>
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ setting('seo_meta_title') }} - {{ $meta['title'] ?? ($settings->default_meta_title ?? config('app.name')) }}</title>
	<meta name="description" content="{{ $meta['description'] ?? (setting('seo_meta_description') ?? '') }}">
	<link rel="icon" href="{{ asset('storage/' . $favicon_path) }}">
	<link rel="stylesheet" href="{{ asset('html/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/unicons/unicons.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/colors/grape.css') }}">
	<link rel="preload" href="{{ asset('assets/css/fonts/urbanist.css') }}" as="style" onload="this.rel='stylesheet'">

	<style>
		<?php  echo setting('custom_css') ?>
	</style>

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
	@if(isset($renderedFooter) && !empty(trim($renderedFooter)))
		{!! $renderedFooter !!}
	@else
		@include('partials.footer')
	@endif

	<script src="{{ asset('assets/js/plugins.js') }}"></script>
	<script src="{{ asset('assets/js/theme.js') }}"></script>
</body>
</html>


