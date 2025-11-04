<footer class="site-footer">
	<div class="container">
    	<p>{{ ($settings->site_name ?? config('app.name')) }} © {{ now()->year }}</p>
    	<div class="social">
			@php $links = $settings->social_links ?? []; @endphp
			@if(!empty($links['facebook'])) <a href="{{ $links['facebook'] }}" rel="nofollow">Facebook</a> @endif
			@if(!empty($links['instagram'])) <a href="{{ $links['instagram'] }}" rel="nofollow">Instagram</a> @endif
			@if(!empty($links['linkedin'])) <a href="{{ $links['linkedin'] }}" rel="nofollow">LinkedIn</a> @endif
			@if(!empty($links['twitter'])) <a href="{{ $links['twitter'] }}" rel="nofollow">X</a> @endif
		</div>
	</div>
</footer>


