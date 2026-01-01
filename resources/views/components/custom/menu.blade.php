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
            <x-front.menu-item :item="$item" />
        @endforeach
    </ul>
@endif
