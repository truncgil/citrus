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
            @endphp
            <li class="nav-item {{ $hasChildren ? 'dropdown' : '' }}">
                @if($hasChildren)
                    <a class="nav-link dropdown-toggle font-bold !tracking-[normal] hover:!text-[#e31e24] !text-[.85rem]" 
                       href="{{ route('page.show', $item->slug) }}" 
                       data-bs-toggle="dropdown">
                        {{ $item->translate('title') ?: $item->title }}
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
                                        {{ $child->translate('title') ?: $child->title }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach($child->children as $grandChild)
                                            <li class="nav-item">
                                                <a class="dropdown-item hover:!text-[#e31e24]" 
                                                   href="{{ route('page.show', $grandChild->slug) }}">
                                                    {{ $grandChild->translate('title') ?: $grandChild->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="dropdown-item hover:!text-[#e31e24]" 
                                       href="{{ route('page.show', $child->slug) }}">
                                        {{ $child->translate('title') ?: $child->title }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <a class="nav-link font-bold !tracking-[normal] hover:!text-[#e31e24] !text-[.85rem]" 
                       href="{{ route('page.show', $item->slug) }}">
                        {{ $item->translate('title') ?: $item->title }}
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
@endif