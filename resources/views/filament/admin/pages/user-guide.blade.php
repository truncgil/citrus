<x-filament-panels::page>
    <div class="flex flex-col lg:flex-row gap-9" x-data="{ search: '' }">
        {{-- Sol Navigation Bar --}}
        <aside class="w-full lg:w-56 lg:flex-shrink-0 flex flex-col overflow-y-auto p-4 [&>[data-slot=section]+[data-slot=section]]:mt-8">
            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex items-center gap-2">
                        <x-filament::icon
                            icon="heroicon-o-book-open"
                            class="w-5 h-5"
                        />
                        {{ __('user-guide.menu_title') }}
                    </x-slot>

                {{-- Search Input --}}
                <div class="fi-section-content">
                    <x-filament::input.wrapper>
                        <x-slot name="prefix">
                            <x-filament::icon
                                icon="heroicon-o-magnifying-glass"
                                class="h-5 w-5 text-gray-400"
                            />
                        </x-slot>
                        <x-filament::input
                            type="text"
                            x-model="search"
                            :placeholder="__('user-guide.search_placeholder')"
                        />
                    </x-filament::input.wrapper>
                </div>

                {{-- Guide List --}}
                <nav class="fi-section-content" style="padding: 10px 0 ;">

                    @foreach($this->getGuides() as $guide)
                        <div
                            data-guide-item
                            data-guide-name="{{ strtolower(\Illuminate\Support\Str::title(str_replace(['-', '_'], ' ', $guide['name']))) }}"
                            x-show="!search || '{{ strtolower(\Illuminate\Support\Str::title(str_replace(['-', '_'], ' ', $guide['name']))) }}'.includes(search.toLowerCase())"
                            x-transition
                        >
                            <x-filament::link
                                wire:click="selectGuide('{{ $guide['slug'] }}')"
                                tag="button"
                                icon="heroicon-o-document-text"
                                :color="$selectedGuide === $guide['slug'] ? 'primary' : 'gray'"
                                weight="medium"
                                class="w-full justify-start group"
                            >
                                <div class="flex justify-between items-center w-full min-w-0">
                                    <span class="truncate">
                                        {{ \Illuminate\Support\Str::title(str_replace(['-', '_'], ' ', $guide['name'])) }}
                                    </span>
                                    @if($selectedGuide === $guide['slug'])
                                        <x-filament::icon
                                            icon="heroicon-o-check-circle"
                                            class="w-5 h-5 ml-2 flex-shrink-0"
                                        />
                                    @endif
                                </div>
                            </x-filament::link>
                        </div>
                    @endforeach

                    @if(empty($this->getGuides()))
                        <div class="text-center py-8">
                            <x-filament::icon
                                icon="heroicon-o-book-open"
                                class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-3"
                            />
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('user-guide.no_guides') }}
                            </p>
                        </div>
                    @endif
                </nav>
            </x-filament::section>
        </aside>

        {{-- Sağ İçerik Alanı --}}
        <main class="w-full min-w-0 order-2 lg:order-2">
            @if($selectedGuide && $this->getSelectedGuideContent())
                @php
                    $guide = $this->getSelectedGuideContent();
                @endphp

                <x-filament::section>
                    <x-slot name="heading">
                        <div class="space-y-1">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ \Illuminate\Support\Str::title(str_replace(['-', '_'], ' ', $guide['name'])) }}
                            </h2>
                            @if(isset($guide['modified_date']))
                                <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                    <x-filament::icon
                                        icon="heroicon-o-clock"
                                        class="w-4 h-4"
                                    />
                                    {{ __('user-guide.last_updated') }}: 
                                    {{ \Carbon\Carbon::parse($guide['modified_date'])->locale(app()->getLocale())->format('d F Y, H:i') }}
                                </p>
                            @endif
                        </div>
                    </x-slot>

                    <x-filament::card>
                        <div class="guide-content prose prose-lg dark:prose-invert max-w-none">
                            {!! \Illuminate\Support\Str::markdown($guide['content'], [
                                'html_input' => 'allow',
                                'allow_unsafe_links' => false,
                            ]) !!}
                        </div>
                    </x-filament::card>
                </x-filament::section>
            @else
                <x-filament::section>
                    <x-slot name="heading">
                        {{ __('user-guide.title') }}
                    </x-slot>

                    <x-filament::card>
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <x-filament::icon
                                icon="heroicon-o-book-open"
                                class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-4"
                            />
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                {{ __('user-guide.no_guide_selected') }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('user-guide.select_guide_from_menu') }}
                            </p>
                        </div>
                    </x-filament::card>
                </x-filament::section>
            @endif
        </main>
    </div>

    @push('styles')
        <style>
            @media (min-width: 1024px) {
                aside {
                    width: 14rem !important;
                    max-width: 14rem !important;
                }
            }
            
            .guide-content {
                @apply text-gray-900 dark:text-gray-100;
            }
            
            .guide-content h1 {
                @apply text-3xl font-bold mb-4 mt-8 text-gray-900 dark:text-gray-100;
            }
            
            .guide-content h2 {
                @apply text-2xl font-semibold mb-3 mt-6 text-gray-900 dark:text-gray-100;
            }
            
            .guide-content h3 {
                @apply text-xl font-semibold mb-2 mt-4 text-gray-900 dark:text-gray-100;
            }
            
            .guide-content p {
                @apply mb-4 text-gray-700 dark:text-gray-300 leading-relaxed;
            }
            
            .guide-content ul, .guide-content ol {
                @apply mb-4 ml-6 text-gray-700 dark:text-gray-300;
            }
            
            .guide-content li {
                @apply mb-2;
            }
            
            .guide-content code {
                @apply bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded text-sm font-mono text-gray-900 dark:text-gray-100;
            }
            
            .guide-content pre {
                @apply bg-gray-100 dark:bg-gray-800 p-4 rounded-lg overflow-x-auto mb-4;
            }
            
            .guide-content pre code {
                @apply bg-transparent p-0;
            }
            
            .guide-content blockquote {
                @apply border-l-4 border-primary-500 pl-4 italic my-4 text-gray-600 dark:text-gray-400;
            }
            
            .guide-content a {
                @apply text-primary-600 dark:text-primary-400 hover:underline;
            }
            
            .guide-content table {
                @apply w-full border-collapse mb-4;
            }
            
            .guide-content th,
            .guide-content td {
                @apply border border-gray-300 dark:border-gray-600 px-4 py-2 text-left;
            }
            
            .guide-content th {
                @apply bg-gray-100 dark:bg-gray-800 font-semibold;
            }
        </style>
    @endpush
</x-filament-panels::page>
