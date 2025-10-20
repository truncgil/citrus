@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title)
@section('description', $page->meta_description ?? $page->excerpt ?? '')

@section('content')

    <!-- Page Header -->
    <section class="relative overflow-hidden bg-gradient-to-br from-white via-red-50/30 to-orange-50/20 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 py-16 lg:py-24">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-red-500/10 dark:bg-red-500/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-orange-500/10 dark:bg-orange-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                    {{ $page->title }}
                </h1>
                
                @if($page->excerpt)
                    <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 leading-relaxed">
                        {{ $page->excerpt }}
                    </p>
                @endif

                @if($page->published_at)
                    <div class="mt-6 flex items-center justify-center text-sm text-gray-500 dark:text-gray-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $page->published_at->format('d M Y') }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Page Content -->
    <section class="py-16 lg:py-24 bg-white dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($page->featured_image)
                <div class="mb-12 rounded-xl overflow-hidden shadow-xl">
                    <img src="{{ $page->featured_image_url }}" alt="{{ $page->title }}" class="w-full h-auto">
                </div>
            @endif

            <div class="prose prose-lg dark:prose-invert max-w-none 
                        prose-headings:text-gray-900 dark:prose-headings:text-white 
                        prose-p:text-gray-600 dark:prose-p:text-gray-300 
                        prose-a:text-red-600 dark:prose-a:text-red-400 hover:prose-a:text-red-700 dark:hover:prose-a:text-red-300
                        prose-strong:text-gray-900 dark:prose-strong:text-white
                        prose-code:text-red-600 dark:prose-code:text-red-400
                        prose-pre:bg-gray-100 dark:prose-pre:bg-gray-800
                        prose-blockquote:border-red-500 dark:prose-blockquote:border-red-400
                        prose-img:rounded-xl prose-img:shadow-lg">
                {!! $page->content !!}
            </div>

            <!-- Child Pages -->
            @if($page->children->where('status', 'published')->count() > 0)
                <div class="mt-16 pt-16 border-t border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">
                        İlgili Sayfalar
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($page->children->where('status', 'published')->sortBy('sort_order') as $child)
                            <a href="{{ $child->url }}" class="group block p-6 bg-gray-50 dark:bg-gray-800 rounded-lg hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">
                                    {{ $child->title }}
                                </h3>
                                @if($child->excerpt)
                                    <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-2">
                                        {{ $child->excerpt }}
                                    </p>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Ana Sayfaya Dön
                </a>

                @if($page->parent)
                    <a href="{{ $page->parent->url }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                        Üst Sayfa
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </section>
@endsection
