@php
    $products = \App\Models\Product::where('is_active', true)->whereNotNull('hero_image')->get();
@endphp

<div class="swiper-container swiper-auto swiper-auto-xs !mb-8 relative !z-10 swiper-container-0" data-margin="40" data-nav="false" data-dots="false" data-centered="true" data-loop="true" data-items-auto="true" data-autoplay="true" data-autoplaytime="1" data-drag="false" data-resizeupdate="false" data-speed="7000">
	<div class="swiper overflow-visible pointer-events-none">
	  <div class="swiper-wrapper ticker">
        @foreach($products as $product)
        <div class="swiper-slide" style="margin-right: 40px;">
            <a href="{{ route('products.show', $product->slug) }}" class="block group relative">
                <figure class="!rounded-[0.8rem] shadow-[rgba(30,34,40,0.02)_0_2px_1px,rgba(30,34,40,0.02)_0_4px_2px,rgba(30,34,40,0.02)_0_8px_4px,rgba(30,34,40,0.02)_0_16px_8px,rgba(30,34,40,0.03)_0_32px_16px] transition-transform duration-300 group-hover:scale-105">
                    <img class="!rounded-[.8rem] h-[300px] w-auto object-cover" src="{{ asset('storage/' . $product->hero_image) }}" alt="{{ $product->translate('title') }}">
                </figure>
                <!-- Tooltip -->
                <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 px-3 py-1 bg-black/80 backdrop-blur-sm text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap z-20">
                    {{ $product->translate('title') }}
                </div>
            </a>
        </div>
        @endforeach
	  </div>
	</div>
</div>

<div class="swiper-container swiper-auto swiper-auto-xs !mb-10 xl:!mb-14 lg:!mb-14 md:!mb-14 relative !z-10 swiper-container-1" data-margin="40" data-nav="false" data-dots="false" data-centered="true" data-loop="true" data-items-auto="true" data-autoplay="true" data-autoplaytime="1" data-drag="false" data-resizeupdate="false" data-speed="7000">
	<div class="swiper overflow-visible pointer-events-none swiper-rtl" dir="rtl">
	  <div class="swiper-wrapper ticker">
        @foreach($products as $product)
        <div class="swiper-slide" style="margin-left: 40px;">
             <a href="{{ route('products.show', $product->slug) }}" class="block group relative">
                <figure class="!rounded-[0.8rem] shadow-[rgba(30,34,40,0.02)_0_2px_1px,rgba(30,34,40,0.02)_0_4px_2px,rgba(30,34,40,0.02)_0_8px_4px,rgba(30,34,40,0.02)_0_16px_8px,rgba(30,34,40,0.03)_0_32px_16px] transition-transform duration-300 group-hover:scale-105">
                    <img class="!rounded-[.8rem] h-[300px] w-auto object-cover" src="{{ asset('storage/' . $product->hero_image) }}" alt="{{ $product->translate('title') }}">
                </figure>
                 <!-- Tooltip -->
                 <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 px-3 py-1 bg-black/80 backdrop-blur-sm text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap z-20">
                    {{ $product->translate('title') }}
                </div>
            </a>
        </div>
        @endforeach
	  </div>
	</div>
</div>