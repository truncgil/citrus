<?php 
// Get menu items from Pages with nested children
$menuItems = \App\Models\Page::with(['children' => function ($query) {
    $query->where('status', 'published')
        ->where('show_in_menu', true)
        ->orderBy('sort_order', 'asc')
        ->orderBy('title', 'asc');
    }, 'children.children' => function ($query) {
        $query->where('status', 'published')
            ->where('show_in_menu', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('title', 'asc');
    }])
    ->whereNull('parent_id')
    ->where('status', 'published')
    ->where('show_in_menu', true)
    ->orderBy('sort_order', 'asc')
    ->orderBy('title', 'asc')
    ->get();
?>

@if($menuItems->isNotEmpty())
    <ul class="navbar-nav">
        @foreach($menuItems as $item)
            @php
                $hasChildren = $item->children->isNotEmpty();
                $isMegaMenu = $item->slug === 'urunlerimiz';
            @endphp

            @if($isMegaMenu)
                <li class="nav-item dropdown dropdown-mega">
                    <a class="nav-link dropdown-toggle font-bold !tracking-[-0.01rem] hover:!text-[#e31e24] after:!text-[#e31e24]" href="{{ route('page.show', $item->slug) }}" data-bs-toggle="dropdown">{{ $item->translate('title') }}</a>
                    <ul class="dropdown-menu mega-menu">
                        <li class="mega-menu-content">
                            <div class="flex flex-wrap mx-0 xl:mx-[-7.5px] lg:mx-[-7.5px]">
                                <div class="xl:w-4/12 lg:w-4/12 w-full flex-[0_0_auto] max-w-full">
                                    <h6 class="dropdown-header !text-[#e31e24]">Kategoriler</h6>
                                    <ul class="pl-0 list-none xl:columns-2 lg:columns-2 xl:pb-1 lg:pb-1">
                                        <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item hover:!text-[#e31e24]' href='#'>Yazılım Çözümleri</a></li>
                                        <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item hover:!text-[#e31e24]' href='#'>Donanım</a></li>
                                        <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item hover:!text-[#e31e24]' href='#'>Danışmanlık</a></li>
                                        <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item hover:!text-[#e31e24]' href='#'>Entegrasyon</a></li>
                                    </ul>
                                    <h6 class="dropdown-header !text-[#e31e24] xl:!mt-6 lg:!mt-6">Sektörler</h6>
                                    <ul class="pl-0 list-none xl:columns-2 lg:columns-2">
                                        <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item hover:!text-[#e31e24]' href='#'>Finans</a></li>
                                        <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item hover:!text-[#e31e24]' href='#'>Sağlık</a></li>
                                        <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item hover:!text-[#e31e24]' href='#'>Eğitim</a></li>
                                        <li class="xl:inline-block xl:w-full lg:inline-block lg:w-full"><a class='dropdown-item hover:!text-[#e31e24]' href='#'>Perakende</a></li>
                                    </ul>
                                </div>
                                <!--/column -->
                                <div class="xl:w-8/12 lg:w-8/12 w-full flex-[0_0_auto] max-w-full xl:border-l-[rgba(164,174,198,0.2)] xl:border-l xl:border-solid lg:border-l-[rgba(164,174,198,0.2)] lg:border-l lg:border-solid">
                                    <h6 class="dropdown-header !text-[#e31e24]">Öne Çıkan Ürünler</h6>
                                    <ul class="pl-0 list-none xl:columns-3 lg:columns-3">
                                        <li><a class='dropdown-item hover:!text-[#e31e24]' href='#'>ERP Sistemi</a></li>
                                        <li><a class='dropdown-item hover:!text-[#e31e24]' href='#'>CRM Modülü</a></li>
                                        <li><a class='dropdown-item hover:!text-[#e31e24]' href='#'>Mobil App</a></li>
                                        <li><a class='dropdown-item hover:!text-[#e31e24]' href='#'>Web Sitesi</a></li>
                                        <li><a class='dropdown-item hover:!text-[#e31e24]' href='#'>E-Ticaret</a></li>
                                        <li><a class='dropdown-item hover:!text-[#e31e24]' href='#'>SEO Paketi</a></li>
                                        <li><a class='dropdown-item hover:!text-[#e31e24]' href='#'>Hosting</a></li>
                                        <li><a class='dropdown-item hover:!text-[#e31e24]' href='#'>Bulut Yedekleme</a></li>
                                        <li><a class='dropdown-item hover:!text-[#e31e24]' href='#'>Siber Güvenlik</a></li>
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
                        <a class="nav-link dropdown-toggle font-bold !tracking-[-0.01rem] hover:!text-[#e31e24] after:!text-[#e31e24]" 
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
                                        <a class="dropdown-item hover:!text-[#e31e24] dropdown-toggle" 
                                           href="{{ route('page.show', $child->slug) }}" 
                                           data-bs-toggle="dropdown">
                                            {{ $child->translate('title') }}
                                        </a>
                                        <ul class="dropdown-menu">
                                            @foreach($child->children as $grandChild)
                                                <li class="nav-item">
                                                    <a class="dropdown-item hover:!text-[#e31e24]" 
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
                        <a class="nav-link font-bold !tracking-[-0.01rem] hover:!text-[#e31e24] after:!text-[#e31e24]" 
                           href="{{ route('page.show', $item->slug) }}">
                            {{ $item->translate('title') }}
                        </a>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
@endif
