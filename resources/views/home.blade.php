@extends('layouts.app')

@section('title', $page ? ($page->meta_title ?? $page->title) : 'Trunçgil Teknoloji')
@section('description', $page ? ($page->meta_description ?? $page->excerpt) : 'Trunçgil Teknoloji - Yenilikçi Çözümler')

@section('content')

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-white via-red-50/30 to-orange-50/20 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 py-20 lg:py-32">
        <div class="absolute inset-0 overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-red-500/10 dark:bg-red-500/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-orange-500/10 dark:bg-orange-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div class="text-center lg:text-left" data-aos="fade-right">
                    @if($page)
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                            {{ $page->title }}
                        </h1>
                        @if($page->excerpt)
                            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                                {{ $page->excerpt }}
                            </p>
                        @endif
                    @else
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                            Hoş Geldiniz
                            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-orange-500">
                                Trunçgil Teknoloji
                            </span>
                        </h1>
                        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                            Yenilikçi teknoloji çözümleri ile geleceği şekillendiriyoruz
                        </p>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#hakkimizda" class="inline-flex items-center justify-center px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                            Keşfet
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        <a href="#iletisim" class="inline-flex items-center justify-center px-8 py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 border-2 border-gray-200 dark:border-gray-700">
                            İletişime Geç
                        </a>
                    </div>
                </div>

                <!-- Image/Logo -->
                <div class="flex justify-center lg:justify-end" data-aos="fade-left">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-tr from-red-500/20 to-orange-500/20 rounded-2xl blur-2xl"></div>
                        <img src="{{ asset('logos/truncgil-dikey.svg') }}" alt="Trunçgil Teknoloji" class="relative h-64 md:h-80 lg:h-96 w-auto drop-shadow-2xl dark:hidden">
                        <img src="{{ asset('logos/truncgil-dikey-dark.svg') }}" alt="Trunçgil Teknoloji" class="relative h-64 md:h-80 lg:h-96 w-auto drop-shadow-2xl hidden dark:block">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($page && $page->content)
        <!-- Page Content -->
        <section class="py-16 lg:py-24 bg-white dark:bg-gray-900">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="prose prose-lg dark:prose-invert max-w-none prose-headings:text-gray-900 dark:prose-headings:text-white prose-p:text-gray-600 dark:prose-p:text-gray-300 prose-a:text-red-600 dark:prose-a:text-red-400">
                    {!! $page->content !!}
                </div>
            </div>
        </section>
    @endif

    <!-- Features Section -->
    <section id="hakkimizda" class="py-16 lg:py-24 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Neden Trunçgil Teknoloji?
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Modern teknolojiler ve uzman ekibimizle projelerinizi hayata geçiriyoruz
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        Hızlı Çözümler
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Modern teknolojiler kullanarak projelerinizi hızlı ve verimli bir şekilde hayata geçiriyoruz.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        Güvenli Altyapı
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        En son güvenlik standartlarını kullanarak verilerinizi koruma altına alıyoruz.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        Uzman Ekip
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Deneyimli ve uzman ekibimiz ile her zaman yanınızdayız.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="iletisim" class="py-16 lg:py-24 bg-gradient-to-br from-red-600 to-orange-600 dark:from-red-700 dark:to-orange-700">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="zoom-in">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Projenizi Konuşalım
            </h2>
            <p class="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
                Size özel çözümler geliştirmek için iletişime geçin
            </p>
            <a href="mailto:info@truncgil.com" class="inline-flex items-center justify-center px-8 py-3 bg-white text-red-600 font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                İletişime Geç
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </a>
        </div>
    </section>
@endsection
