<div class="page-wrapper">
    {{-- Render Header Template --}}
    @if($page->headerTemplate)
        <div class="page-header">
            {!! $renderHeader() !!}
        </div>
    @endif

    {{-- Render Page Sections --}}
    <main class="page-content">
        {{-- Legacy sections (if exists) --}}
        @if($page->sections && count($page->sections) > 0)
            <div class="legacy-sections">
                @foreach($page->sections as $section)
                    <x-dynamic-component :component="'blocks.' . ($section['type'] ?? 'custom')" :data="$section['data'] ?? []" />
                @endforeach
            </div>
        @endif

        {{-- New template-based sections --}}
        @if($page->sections_data && count($page->sections_data) > 0)
            <div class="template-sections">
                {!! $renderSections() !!}
            </div>
        @endif

        {{-- Fallback to content field if no sections --}}
        @if((!$page->sections || count($page->sections) === 0) && (!$page->sections_data || count($page->sections_data) === 0))
            <div class="page-content-body">
                {!! $page->content !!}
            </div>
        @endif
    </main>

    {{-- Render Footer Template --}}
    @if($page->footerTemplate)
        <div class="page-footer">
            {!! $renderFooter() !!}
        </div>
    @endif
</div>