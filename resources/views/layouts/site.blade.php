<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $meta['title'] ?? ($settings->default_meta_title ?? config('app.name')) }}</title>
	<meta name="description" content="{{ $meta['description'] ?? ($settings->default_meta_description ?? '') }}">
	<link rel="icon" href="{{ $settings?->favicon_path ? asset($settings->favicon_path) : asset('assets/img/favicon.ico') }}">
	<link rel="stylesheet" href="{{ asset('html/style.css') }}">
</head>
<body>
	@include('partials.navbar')
	@yield('content')
	@include('partials.footer')

	{{-- İsteğe bağlı: tema JS dosyalarınız varsa buraya ekleyin --}}
	{{-- <script src="{{ asset('assets/js/main.js') }}" defer></script> --}}
</body>
</html>


