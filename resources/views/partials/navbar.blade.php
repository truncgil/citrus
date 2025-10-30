<header class="site-header">
	<div class="container">
		<a href="{{ route('home') }}" class="logo">
			@if(isset($settings) && !empty($settings->logo_path))
				<img src="{{ asset($settings->logo_path) }}" alt="{{ $settings?->translate('site_name') ?? config('app.name') }}">
			@else
				<span>{{ $settings->site_name ?? config('app.name') }}</span>
			@endif
		</a>
		<nav class="main-nav">
			<ul>
				<li><a href="{{ route('home') }}">{{ __('pages.nav-home') }}</a></li>
				<li><a href="{{ url('/about') }}">{{ __('pages.nav-about') }}</a></li>
				<li><a href="{{ url('/services') }}">{{ __('pages.nav-services') }}</a></li>
				<li><a href="{{ url('/blog') }}">{{ __('blog.nav-blog') }}</a></li>
				<li><a href="{{ url('/contact') }}">{{ __('pages.nav-contact') }}</a></li>
			</ul>
		</nav>
	</div>
</header>


