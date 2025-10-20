<footer class="bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo ve Açıklama -->
            <div class="col-span-1 md:col-span-2">
                <img src="{{ asset('logos/truncgil-yatay.svg') }}" alt="Trunçgil Teknoloji" class="h-10 mb-4 dark:hidden">
                <img src="{{ asset('logos/truncgil-yatay-dark.svg') }}" alt="Trunçgil Teknoloji" class="h-10 mb-4 hidden dark:block">
                <p class="text-gray-600 dark:text-gray-400 mt-4 max-w-md">
                    Trunçgil Teknoloji olarak, yenilikçi ve güvenilir teknoloji çözümleri sunuyoruz.
                </p>
            </div>

            <!-- Hızlı Linkler -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider mb-4">
                    Hızlı Linkler
                </h3>
                <ul class="space-y-3">
                    @foreach($menuItems->take(4) as $item)
                        <li>
                            <a href="{{ $item->url }}" class="text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors duration-150">
                                {{ $item->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- İletişim -->
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider mb-4">
                    İletişim
                </h3>
                <ul class="space-y-3 text-gray-600 dark:text-gray-400">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="mailto:info@truncgil.com" class="hover:text-red-600 dark:hover:text-red-400 transition-colors duration-150">
                            info@truncgil.com
                        </a>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>+90 (XXX) XXX XX XX</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
            <p class="text-center text-gray-500 dark:text-gray-400 text-sm">
                &copy; {{ date('Y') }} Trunçgil Teknoloji. Tüm hakları saklıdır.
            </p>
        </div>
    </div>
</footer>



