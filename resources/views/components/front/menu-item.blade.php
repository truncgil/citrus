@props(['item'])

@php
    $hasChildren = $item->children->isNotEmpty();
    $isMegaMenu = $item->slug === 'urunlerimiz';

    $productCategories = [];
    if($isMegaMenu) {
        $productCategories = \App\Models\ProductCategory::with(['products' => function($q) {
            $q->where('is_active', true)->orderBy('sort_order');
        }])->where('is_active', true)->orderBy('sort_order')->get();
    }
@endphp

@if($isMegaMenu)
    <li class="nav-item dropdown dropdown-mega">
        <a class="nav-link dropdown-toggle font-bold !tracking-[normal]" href="{{ route('page.show', $item->slug) }}" data-bs-toggle="dropdown">{{ $item->translate('title') }}</a>
        <ul class="dropdown-menu mega-menu">
            <li class="mega-menu-content">
                <div class="flex flex-wrap mx-0 xl:mx-[-7.5px] lg:mx-[-7.5px]">
                    @foreach($productCategories as $category)
                    <div class="xl:w-3/12 lg:w-3/12 md:w-6/12 w-full flex-[0_0_auto] max-w-full mb-8 px-[7.5px]">
                        <h6 class="dropdown-header !text-[#e31e24] mb-4 border-b border-gray-100 pb-2">
                            {{ $category->translate('title') }}
                        </h6>
                        <ul class="pl-0 list-none space-y-3">
                            @foreach($category->products as $product)
                                <li>
                                    <a class='dropdown-item hover:!text-[#e31e24] group flex items-center gap-3 !p-0 !bg-transparent' href='{{ route('products.show', $product->slug) }}'>
                                        <div class="img-mask mask-3 w-10 h-10 shrink-0 bg-gray-100">
                                            @if($product->hero_image)
                                                <img src="{{ \Storage::url($product->hero_image) }}" alt="{{ $product->translate('title') }}" class="w-full h-full object-cover" />
                                            @endif
                                        </div>
                                        <span class="text-sm font-medium group-hover:pl-1 transition-all">{{ $product->translate('title') }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
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
