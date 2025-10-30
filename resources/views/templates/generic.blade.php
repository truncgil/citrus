@extends('layouts.site')

@section('content')
	@php $blocks = $sections ?? []; @endphp
	@if(is_array($blocks))
		@foreach($blocks as $block)
			@php $type = $block['type'] ?? null; @endphp
			@if($type && view()->exists("components.templates.$type"))
				@include("components.templates.$type", ['data' => $block['props'] ?? $block])
			@endif
		@endforeach
	@endif
@endsection


