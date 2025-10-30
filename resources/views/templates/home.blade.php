@extends('layouts.site')

@section('content')
	@php
		// Admin verisi varsa ve boş değilse dinamik render, yoksa statik HTML
		$pageData = $page->data ?? [];
		$hasDynamic = is_array($pageData) && count($pageData) > 0;
	@endphp

	@if($hasDynamic)
		{{-- Dinamik (admin) veri ile render --}}
		<section class="hero">
			<div class="container">
				<h1>{{ data_get($page->data ?? [], 'hero_title') }}</h1>
				<p>{{ data_get($page->data ?? [], 'hero_subtitle') }}</p>
				@if($img = data_get($page->data ?? [], 'hero_image'))
					<img src="{{ asset($img) }}" alt="hero">
				@endif
				<div class="hero-actions">
					@if($btn = data_get($page->data ?? [], 'hero_primary_url'))
						<a href="{{ $btn }}" class="btn">{{ data_get($page->data ?? [], 'hero_primary_text') }}</a>
					@endif
					@if($btn2 = data_get($page->data ?? [], 'hero_secondary_url'))
						<a href="{{ $btn2 }}" class="btn btn-outline">{{ data_get($page->data ?? [], 'hero_secondary_text') }}</a>
					@endif
				</div>
			</div>
		</section>

		@if($features = data_get($page->data ?? [], 'features', []))
		<section class="features">
			<div class="container">
				<div class="grid">
					@foreach($features as $item)
						<div class="feature-item">
							@if(!empty($item['icon'])) <img src="{{ asset($item['icon']) }}" alt=""> @endif
							<h3>{{ $item['title'] ?? '' }}</h3>
							<p>{{ $item['text'] ?? '' }}</p>
						</div>
					@endforeach
				</div>
			</div>
		</section>
		@endif

		@if(data_get($page->data ?? [], 'cta_title'))
		<section class="cta">
			<div class="container">
				<h2>{{ data_get($page->data ?? [], 'cta_title') }}</h2>
				<a class="btn" href="{{ data_get($page->data ?? [], 'cta_button_url', '#') }}">
					{{ data_get($page->data ?? [], 'cta_button_text') }}
				</a>
			</div>
		</section>
		@endif
	@else
		{{-- Statik fallback: public/html/index.html içeriğinin <body> bölümü --}}
		@php
			$indexPath = public_path('html/index.html');
			$bodyHtml = '';
			if (file_exists($indexPath) && is_readable($indexPath)) {
				$html = file_get_contents($indexPath);
				// Body içeriğini çıkar
				if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $m)) {
					$bodyHtml = $m[1];
				}
			}
			// Eğer body boşsa placeholder göster
			if (empty(trim($bodyHtml))) {
				$bodyHtml = '<div class="container py-20"><h1>Admin panelinden anasayfa içeriği ekleyin veya index.html kontrol edin.</h1></div>';
			}
		@endphp
		{!! $bodyHtml !!}
	@endif
@endsection


