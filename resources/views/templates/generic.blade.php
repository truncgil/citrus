@extends('layouts.site')

@section('content')
	@php $blocks = $sections ?? []; @endphp
	@if(is_array($blocks) && !empty($blocks))
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


