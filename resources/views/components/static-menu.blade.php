<?php 
   // Get menu items from Pages
   $menuItems = \App\Models\Page::with(['children' => function ($query) {
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
    <nav class="static-menu">
        <ul class="static-menu-list">
            @foreach($menuItems as $item)
                @php
                    $hasChildren = $item->children->isNotEmpty();
                @endphp
                <li class="static-menu-item {{ $hasChildren ? 'has-children' : '' }}">
                    <a href="{{ route('page.show', $item->slug) }}" class="static-menu-link">
                        {{ $item->title }}
                    </a>
                    
                    @if($hasChildren)
                        <ul class="static-submenu">
                            @foreach($item->children as $child)
                                <li class="static-submenu-item">
                                    <a href="{{ route('page.show', $child->slug) }}" class="static-submenu-link">
                                        {{ $child->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </nav>
@endif

