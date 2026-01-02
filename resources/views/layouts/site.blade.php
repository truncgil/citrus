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
	<link rel="preload" href="{{ asset('assets/css/fonts/space.css') }}" as="style" onload="this.rel='stylesheet'">

	<style>
		<?php  echo setting('custom_css') ?>
	</style>

</head>
<body>
	{{-- Dynamic Header Template or Static Navbar --}}
	@php
		$finalHeader = null;
		
		// 1. String Başlık Kontrolü: Eğer string geldiyse (örn: "Demo29 Header"), modelini bul
		if (isset($headerTemplate) && is_string($headerTemplate)) {
			$foundTemplate = \App\Models\HeaderTemplate::where('title', $headerTemplate)
				->where('is_active', true)
				->first();
			if ($foundTemplate) {
				$headerTemplate = $foundTemplate;
			}
		}

		// 2. Model Instance Varsa Render Et (En Yüksek Öncelik)
		// Kullanıcı template seçtiyse bu çalışır ve renderedHeader'ı ezer.
		if (isset($headerTemplate) && $headerTemplate instanceof \App\Models\HeaderTemplate) {
			$templateDefaults = $headerTemplate->default_data ?? [];
			$templateData = $header_data ?? [];
			$mergedData = array_merge($templateDefaults, $templateData);
			$model = $page ?? null;
			$finalHeader = \App\Services\TemplateService::replacePlaceholders(
				$headerTemplate->html_content,
				$mergedData,
				$model
			);
		}
		
		// 3. Blade dosyası path'i varsa include et (RenderedHeader'dan ÖNCE kontrol edilmeli)
		if (!$finalHeader && isset($header) && $header) {
			$finalHeader = view($header)->render();
		}

		// 4. Eğer yukarıdan sonuç çıkmadıysa ve Controller zaten render ettiyse onu kullan
		if (!$finalHeader && isset($renderedHeader) && $renderedHeader) {
			$finalHeader = $renderedHeader;
		}
	@endphp
	
	@if($finalHeader)
		{!! $finalHeader !!}
	@else
		@include('partials.header')
	@endif
	
	{{-- Main Content --}}
	@yield('content')

	{{-- Dynamic Footer Template or Static Footer --}}
	@php
		$finalFooter = null;
		
		// 1. String Başlık Kontrolü
		if (isset($footerTemplate) && is_string($footerTemplate)) {
			$foundTemplate = \App\Models\FooterTemplate::where('title', $footerTemplate)
				->where('is_active', true)
				->first();
			if ($foundTemplate) {
				$footerTemplate = $foundTemplate;
			}
		}

		// 2. Model Instance Varsa Render Et (En Yüksek Öncelik)
		if (isset($footerTemplate) && $footerTemplate instanceof \App\Models\FooterTemplate) {
			$templateDefaults = $footerTemplate->default_data ?? [];
			$templateData = $footer_data ?? [];
			$mergedData = array_merge($templateDefaults, $templateData);
			$model = $page ?? null;
			$finalFooter = \App\Services\TemplateService::replacePlaceholders(
				$footerTemplate->html_content,
				$mergedData,
				$model
			);
		}

		// 3. Blade dosyası path'i (RenderedFooter'dan ÖNCE)
		if (!$finalFooter && isset($footer) && $footer) {
			$finalFooter = view($footer)->render();
		}

		// 4. Controller'dan gelen renderedFooter
		if (!$finalFooter && isset($renderedFooter) && !empty(trim($renderedFooter ?? ''))) {
			$finalFooter = $renderedFooter;
		}
	@endphp
	
	@if($finalFooter)
		{!! $finalFooter !!}
	@else
		@include('partials.footer')
	@endif

	<script src="{{ asset('assets/js/plugins.js') }}"></script>
	<script src="{{ asset('assets/js/theme.js') }}"></script>
</body>
</html>


