@extends('layouts.site')

@section('content')
<section class="blog-list">
	<div class="container">
		<div class="grid">
			@forelse($posts as $post)
				<article class="card">
					@if(!empty($post->featured_image))
						<a href="{{ route('blog.show', $post->slug) }}">
							<img src="{{ asset($post->featured_image) }}" alt="{{ method_exists($post, 'translate') ? $post->translate('title') : $post->title }}">
						</a>
					@endif
					<h3>
						<a href="{{ route('blog.show', $post->slug) }}">{{ method_exists($post, 'translate') ? $post->translate('title') : $post->title }}</a>
					</h3>
					<p>{{ method_exists($post, 'translate') ? $post->translate('excerpt') : ($post->excerpt ?? '') }}</p>
				</article>
			@empty
				<p>{{ __('blog.empty') }}</p>
			@endforelse
		</div>

		@if(method_exists($posts, 'links'))
			{{ $posts->links() }}
		@endif
	</div>
</section>
@endsection


