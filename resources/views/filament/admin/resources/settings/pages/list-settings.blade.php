<!-- CUSTOM SETTINGS VIEW LOADED -->
<x-filament-panels::page>
    <div class="grid grid-cols-12 gap-6">
        <!-- Left Sidebar - Vertical Tabs -->
        <div class="col-span-12 lg:col-span-3">
            <div class="fi-section rounded-xl bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
                <div class="p-4">
                    <h3 class="text-sm font-semibold text-gray-950 dark:text-white mb-4">
                        {{ __('settings.tabs_title') }}
                    </h3>
                    
                    <nav class="space-y-1" aria-label="Settings Groups">
                        <!-- Tüm Ayarlar -->
                        <a
                            href="{{ request()->url() }}"
                            wire:navigate
                            @class([
                                'group flex items-center gap-3 px-3 py-2.5 rounded-lg w-full text-left transition-all',
                                'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 font-medium ring-1 ring-primary-500/20' => $activeGroup === null,
                                'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' => $activeGroup !== null,
                            ])
                        >
                            <x-filament::icon 
                                :icon="$this->getGroupIcon(null)" 
                                @class([
                                    'h-5 w-5 transition-colors shrink-0',
                                    'text-primary-600 dark:text-primary-400' => $activeGroup === null,
                                    'text-gray-400 dark:text-gray-500 group-hover:text-gray-600' => $activeGroup !== null,
                                ])
                            />
                            <span class="flex-1 text-sm font-medium">{{ __('settings.all_settings') }}</span>
                            <span @class([
                                'px-2 py-0.5 text-xs rounded-full font-medium min-w-[1.5rem] text-center',
                                'bg-primary-100 dark:bg-primary-800 text-primary-700 dark:text-primary-300' => $activeGroup === null,
                                'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400' => $activeGroup !== null,
                            ])>
                                {{ $this->getGroupCount(null) }}
                            </span>
                        </a>

                        <!-- Divider -->
                        <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>

                        <!-- Gruplar -->
                        @foreach($this->getGroups() as $groupKey => $groupLabel)
                                    <a
                                href="{{ request()->url() }}?group={{ $groupKey }}"
                                wire:navigate
                                @class([
                                    'group flex items-center gap-3 px-3 py-2.5 rounded-lg w-full text-left transition-all',
                                    'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 font-medium ring-1 ring-primary-500/20' => $activeGroup === $groupKey,
                                    'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' => $activeGroup !== $groupKey,
                                ])
                            >
                                <x-filament::icon 
                                    :icon="$this->getGroupIcon($groupKey)" 
                                    @class([
                                        'h-5 w-5 transition-colors shrink-0',
                                        'text-primary-600 dark:text-primary-400' => $activeGroup === $groupKey,
                                        'text-gray-400 dark:text-gray-500 group-hover:text-gray-600' => $activeGroup !== $groupKey,
                                    ])
                                />
                                <span class="flex-1 text-sm font-medium">{{ $groupLabel }}</span>
                                <span @class([
                                    'px-2 py-0.5 text-xs rounded-full font-medium min-w-[1.5rem] text-center',
                                    'bg-primary-100 dark:bg-primary-800 text-primary-700 dark:text-primary-300' => $activeGroup === $groupKey,
                                    'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400' => $activeGroup !== $groupKey,
                                ])>
                                    {{ $this->getGroupCount($groupKey) }}
                                </span>
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>

        <!-- Right Content Area - Settings Table -->
        <div class="col-span-12 lg:col-span-9">
            <!-- Active Group Header -->
            @if($activeGroup)
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-50 dark:bg-primary-900/20">
                        <x-filament::icon 
                            :icon="$this->getGroupIcon($activeGroup)" 
                            class="h-5 w-5 text-primary-600 dark:text-primary-400"
                        />
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ $this->getGroups()->get($activeGroup) }}
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $this->getGroupCount($activeGroup) }} {{ __('settings.settings_count') }}
                        </p>
                    </div>
                </div>
            @else
                <div class="mb-4 flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-50 dark:bg-primary-900/20">
                        <x-filament::icon 
                            :icon="$this->getGroupIcon(null)" 
                            class="h-5 w-5 text-primary-600 dark:text-primary-400"
                        />
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ __('settings.all_settings') }}
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $this->getGroupCount(null) }} {{ __('settings.settings_count') }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Table -->
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>

