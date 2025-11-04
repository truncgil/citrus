@extends('layouts.site')

@section('content')
	@php
		// Yeni dinamik template sistemi - Öncelik verilir
		$hasTemplatedSections = isset($templatedSections) && $templatedSections->isNotEmpty();
		
		// Eski section builder sistemi
		$blocks = $sections ?? [];
		$hasBlocks = is_array($blocks) && !empty($blocks);
	@endphp

	@if($hasTemplatedSections)
		{{-- Yeni dinamik template sisteminden gelen sections --}}
		@foreach($templatedSections as $section)
			@if($section['template'] ?? null)
				{!! \App\Services\TemplateService::replacePlaceholders(
					$section['template']->html_content,
					$section['data'] ?? []
				) !!}
			@endif
		@endforeach
	@elseif($hasBlocks)
		{{-- Eski blok bazlı dinamik render --}}
		@foreach($blocks as $block)
			@php $type = $block['type'] ?? null; @endphp
			@if($type && view()->exists("components.blocks.$type"))
				<x-dynamic-component :component="'blocks.'.$type" :data="$block['data'] ?? $block" />
			@endif
		@endforeach
	@else
		{{-- Hiç blok yoksa placeholder göster --}}
		<div class="container py-24 text-center">
			<h2 class="!text-[2rem] !mb-4">Bu sayfa henüz içerik eklenmemiş</h2>
			<p>Admin panelinden bu sayfaya bloklar ekleyebilirsiniz.</p>
		</div>
	@endif
@endsection


