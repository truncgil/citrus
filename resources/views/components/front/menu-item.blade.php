@props(['item'])

@php
    $hasChildren = $item->children->isNotEmpty();
    $isMegaMenu = $item->slug === 'urunlerimiz';

    $categories = [];
    $services = [];
    if($isMegaMenu) {
        $categories = \App\Models\ProductCategory::where('is_active', true)->orderBy('sort_order')->get();
        $services = \App\Models\Product::where('is_active', true)->orderBy('sort_order')->limit(10)->get();
    }
@endphp

@if($isMegaMenu)
    <li class="nav-item dropdown dropdown-mega">
        <a class="nav-link dropdown-toggle font-bold !tracking-[normal]" href="{{ route('page.show', $item->slug) }}" data-bs-toggle="dropdown">{{ $item->translate('title') }}</a>
        <ul class="dropdown-menu mega-menu">
            <li class="mega-menu-content">
                <div class="flex flex-wrap mx-0 xl:mx-[-7.5px] lg:mx-[-7.5px]">
                    <div class="xl:w-4/12 lg:w-4/12 w-full flex-[0_0_auto] max-w-full">
                        <h6 class="dropdown-header !text-[#e31e24]">{{ __('Kategoriler') }}</h6>
                        <ul class="pl-0 list-none xl:columns-2 lg:columns-2 xl:pb-1 lg:pb-1">
                            @foreach($categories as $category)
                            <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full">
                                <a class='dropdown-item hover:!text-[#e31e24]' href='#'>{{ $category->translate('title') }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!--/column -->
                    <div class="xl:w-8/12 lg:w-8/12 w-full flex-[0_0_auto] max-w-full xl:border-l-[rgba(164,174,198,0.2)] xl:border-l xl:border-solid lg:border-l-[rgba(164,174,198,0.2)] lg:border-l lg:border-solid xl:pl-[15px] lg:pl-[15px]">
                        <h6 class="dropdown-header !text-[#e31e24] !ml-[10px]">{{ __('Öne Çıkan Ürünler') }}</h6>
                        <ul class="pl-0 list-none flex flex-wrap -mx-[10px]">
                            @foreach($services as $service)
                            <li class="xl:w-4/12 lg:w-4/12 w-full flex-[0_0_auto] xl:px-[10px] xl:mt-[10px] lg:px-[10px] lg:mt-[10px]">
                                <a class="dropdown-item group !bg-transparent !p-0 text-center" href="{{ route('products.show', $service->slug) }}">
                                    <figure class="!rounded-[.4rem] lift hidden xl:block lg:block !mb-2 shadow-sm border border-gray-100 relative overflow-hidden aspect-[4/3]">
                                        @if($service->hero_image)
                                            <img class="!rounded-[.4rem] w-full h-full object-cover transition-all duration-300 group-hover:scale-105" src="{{ \Storage::url($service->hero_image) }}" alt="{{ $service->translate('title') }}">
                                        @else
                                            <img class="!rounded-[.4rem] w-full h-full object-cover" src="https://placehold.co/600x400?text={{ urlencode($service->translate('title')) }}" alt="{{ $service->translate('title') }}">
                                        @endif
                                    </figure>
                                    <span class="xl:!hidden lg:!hidden">{{ $service->translate('title') }}</span>
                                    <span class="hidden xl:block lg:block text-xs font-bold text-gray-800 group-hover:text-[#e31e24]">{{ $service->translate('title') }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
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
