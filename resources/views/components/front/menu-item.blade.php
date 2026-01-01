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
                    <div class="xl:w-3/12 lg:w-3/12 w-full flex-[0_0_auto] max-w-full px-6">
                        <h6 class="dropdown-header !text-[#e31e24] mb-4 mt-4 !pl-0">{{ __('Kategoriler') }}</h6>
                        <ul class="pl-0 list-none mb-8">
                            @foreach($categories as $category)
                            <li class="w-full">
                                <a class='dropdown-item hover:!text-[#e31e24] !pl-0 !bg-transparent' href='#'>{{ $category->translate('title') }}</a>
                            </li>
                            @endforeach
                        </ul>

                        <h6 class="dropdown-header !text-[#e31e24] mb-4 mt-4 !pl-0">{{ __('Hizmetler') }}</h6>
                        <ul class="pl-0 list-none">
                            @foreach($services as $service)
                            <li class="w-full">
                                <a class='dropdown-item hover:!text-[#e31e24] !pl-0 !bg-transparent' href="{{ route('products.show', $service->slug) }}">{{ $service->translate('title') }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="xl:w-9/12 lg:w-9/12 w-full flex-[0_0_auto] max-w-full xl:border-l-[rgba(164,174,198,0.2)] xl:border-l xl:border-solid lg:border-l-[rgba(164,174,198,0.2)] lg:border-l lg:border-solid xl:p-[50px] lg:pl-[50px] px-6 gradient-2 rounded-[.4rem]">
                        <h6 class="dropdown-header !text-white mb-6 !p-0">{{ __('Öne Çıkan Ürünler') }}</h6>
                        <div class="flex flex-wrap gap-4 mx-6">
                            @foreach($featuredProducts as $item)
                            <div class="flex-none" style="width: 183px;">
                                <a class="group !bg-transparent mt-2 mb-2 !p-0 block transition-transform duration-300  hover:-translate-y-1" 
                                   href="{{ route('products.show', $item->slug) }}"
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="top" 
                                   title="{{ $item->translate('title') }}">
                                    <figure style="width: 183px; height: 103px;"
                                        class="!rounded-[.4rem] lift overflow-hidden !mb-2 shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.57)] mx-auto block transition-transform duration-300 group-hover:-translate-y-1 hidden xl:block lg:block ">
                                        @if($item->hero_image)
                                            <img style="width: 183px; height: 103px;" class="!rounded-[.4rem] object-cover block" src="{{ \Storage::url($item->hero_image) }}" alt="{{ $item->translate('title') }}">
                                        @else
                                            <img style="width: 183px; height: 103px;" class="!rounded-[.4rem] object-cover block" src="https://placehold.co/185x135?text={{ urlencode($item->translate('title')) }}" alt="{{ $item->translate('title') }}">
                                        @endif
                                    </figure>
                                    <span class="xl:!hidden lg:!hidden">{{ $item->translate('title') }}</span>
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
