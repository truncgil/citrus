@extends('layouts.site')

@section('content')
	@php
		// sections varsa blok bazlı render, yoksa index.html fallback
		$blocks = $sections ?? [];
		$hasBlocks = is_array($blocks) && count($blocks) > 0;
	@endphp

	@if($hasBlocks)
		{{-- Blok bazlı dinamik render --}}
		@foreach($blocks as $block)
			@php $type = $block['type'] ?? null; @endphp
			@if($type && view()->exists("components.blocks.$type"))
				<x-dynamic-component :component="'blocks.'.$type" :data="$block['data'] ?? $block" />
			@endif
		@endforeach
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


