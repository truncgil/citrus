@extends('layouts.site')

@section('content')
<article class="post">
	<div class="container">
		<h1>{{ method_exists($post, 'translate') ? $post->translate('title') : $post->title }}</h1>
		@if(!empty($post->featured_image))
			<img src="{{ asset($post->featured_image) }}" alt="{{ method_exists($post, 'translate') ? $post->translate('title') : $post->title }}">
		@endif
		<div class="post-content">
			{!! method_exists($post, 'translate') ? $post->translate('content') : ($post->content ?? '') !!}
		</div>
	</div>
</article>
@endsection


