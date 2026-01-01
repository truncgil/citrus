@props(['item'])

@php
    $hasChildren = $item->children->isNotEmpty();
    $isMegaMenu = $item->slug === 'urunlerimiz';

    $categories = [];
    $services = [];
    $featuredProducts = [];
    if($isMegaMenu) {
        $categories = \App\Models\ProductCategory::where('is_active', true)->orderBy('sort_order')->get();
        $services = \App\Models\Product::where('is_active', true)->where('type', 'service')->orderBy('sort_order')->limit(10)->get();
        $featuredProducts = \App\Models\Product::where('is_active', true)->where('type', '!=', 'service')->inRandomOrder()->limit(6)->get();
    }
@endphp

@if($isMegaMenu)
    <li class="nav-item dropdown dropdown-mega">
        <a class="nav-link dropdown-toggle font-bold !tracking-[normal]" href="{{ route('page.show', $item->slug) }}" data-bs-toggle="dropdown">{{ $item->translate('title') }}</a>
        <ul class="dropdown-menu mega-menu">
            <li class="mega-menu-content">
                <div class="flex flex-wrap mx-0 xl:mx-[-7.5px] lg:mx-[-7.5px]">
                    <div class="xl:w-3/12 lg:w-3/12 w-full flex-[0_0_auto] max-w-full">
                        <h6 class="dropdown-header !text-[#e31e24]">{{ __('Kategoriler') }}</h6>
                        <ul class="pl-0 list-none xl:pb-1 lg:pb-1">
                            @foreach($categories as $category)
                            <li class="w-full">
                                <a class='dropdown-item hover:!text-[#e31e24]' href='#'>{{ $category->translate('title') }}</a>
                            </li>
                            @endforeach
                        </ul>

                        <h6 class="dropdown-header !text-[#e31e24] mt-5">{{ __('Hizmetler') }}</h6>
                        <ul class="pl-0 list-none xl:pb-1 lg:pb-1">
                            @foreach($services as $service)
                            <li class="w-full">
                                <a class='dropdown-item hover:!text-[#e31e24]' href="{{ route('products.show', $service->slug) }}">{{ $service->translate('title') }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="xl:w-9/12 lg:w-9/12 w-full flex-[0_0_auto] max-w-full xl:border-l-[rgba(164,174,198,0.2)] xl:border-l xl:border-solid lg:border-l-[rgba(164,174,198,0.2)] lg:border-l lg:border-solid xl:pl-[15px] lg:pl-[15px]">
                        <h6 class="dropdown-header !text-[#e31e24] !ml-[10px]">{{ __('Öne Çıkan Ürünler') }}</h6>
                        <div class="flex flex-wrap p-2 gap-4">
                            @foreach($featuredProducts as $item)
                            <div class="flex-none w-[185px]">
                                <a class="dropdown-item group !bg-transparent !p-0 text-center block" href="{{ route('products.show', $item->slug) }}">
                                    <figure class="!rounded-[.4rem] overflow-hidden w-[185px] h-[135px] !mb-2 shadow-sm border border-gray-100 mx-auto">
                                        @if($item->hero_image)
                                            <img class="!rounded-[.4rem] w-full h-full object-cover transition-all duration-300 group-hover:scale-105" src="{{ \Storage::url($item->hero_image) }}" alt="{{ $item->translate('title') }}" width="185" height="135">
                                        @else
                                            <img class="!rounded-[.4rem] w-full h-full object-cover" src="https://placehold.co/185x135?text={{ urlencode($item->translate('title')) }}" alt="{{ $item->translate('title') }}" width="185" height="135">
                                        @endif
                                    </figure>
                                    <span class="xl:!hidden lg:!hidden">{{ $item->translate('title') }}</span>
                                    <span class="hidden xl:block lg:block text-xs font-bold text-gray-800 group-hover:text-[#e31e24] truncate w-full text-center">{{ $item->translate('title') }}</span>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!--/column -->
                </div>
                <!--/.row -->
            </li>
            <!--/.mega-menu-content-->
        </ul>
        <!--/.dropdown-menu -->
    </li>
@else
    <li class="nav-item {{ $hasChildren ? 'dropdown' : '' }}">
        @if($hasChildren)
            <a class="nav-link dropdown-toggle font-bold !tracking-[normal]" 
               href="{{ route('page.show', $item->slug) }}" 
               data-bs-toggle="dropdown">
                {{ $item->translate('title') }}
            </a>
            <ul class="dropdown-menu">
                @foreach($item->children as $child)
                    @php
                        $childHasChildren = $child->children->isNotEmpty();
                    @endphp
                    @if($childHasChildren)
                        <li class="dropdown dropdown-submenu dropend">
                            <a class="nav-link dropdown-toggle font-bold !tracking-[normal]" 
                               href="{{ route('page.show', $child->slug) }}" 
                               data-bs-toggle="dropdown">
                                {{ $child->translate('title') }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($child->children as $grandChild)
                                    <li class="nav-item">
                                        <a class="nav-link dropdown-toggle font-bold !tracking-[normal]" 
                                           href="{{ route('page.show', $grandChild->slug) }}">
                                            {{ $grandChild->translate('title') }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="dropdown-item hover:!text-[#e31e24]" 
                               href="{{ route('page.show', $child->slug) }}">
                                {{ $child->translate('title') }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        @else
            <a class="nav-link font-bold !tracking-[normal]" 
               href="{{ route('page.show', $item->slug) }}">
                {{ $item->translate('title') }}
            </a>
        @endif
    </li>
@endif
