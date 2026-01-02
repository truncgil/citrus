<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use App\Models\Language;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;

class LandingPageSection
{
    private static function getIconOptions(): array
    {
        $icons = [
            'cloud-network-2', 'touchscreen', 'lock', 'rocket', 'bar-chart', 'safe',
            'controls', 'checked', 'calendar', 'currency', 'server', 'devices',
            'search', 'compare', 'smartphone', 'headphone', 'secure', 'verified',
            'wallet', 'shopping-cart', 'e-commerce', 'code', 'bulb', 'gears',
            'shield', 'star', 'check-circle', 'bolt', 'zap', 'heart', 'gift',
        ];
        
        return array_combine($icons, array_map(fn($icon) => ucwords(str_replace('-', ' ', $icon)), $icons));
    }

    private static function getBackgroundOptions(): array
    {
        $backgrounds = [
            // Abstract backgrounds
            'assets/img/photos/bg2.jpg' => 'Background 2 (Abstract)',
            'assets/img/photos/bg3.jpg' => 'Background 3 (Abstract)',
            'assets/img/photos/bg4.jpg' => 'Background 4 (Abstract)',
            'assets/img/photos/bg13.jpg' => 'Background 13 (Abstract)',
            // Gradient backgrounds
            'assets/img/photos/bg14.png' => 'Background 14 (Gradient)',
            'assets/img/photos/bg15.png' => 'Background 15 (Gradient)',
            'assets/img/photos/bg16.png' => 'Background 16 (Gradient)',
            'assets/img/photos/bg17.png' => 'Background 17 (Gradient)',
            'assets/img/photos/bg18.png' => 'Background 18 (Gradient)',
            'assets/img/photos/bg19.png' => 'Background 19 (Gradient)',
            'assets/img/photos/bg20.png' => 'Background 20 (Gradient)',
            'assets/img/photos/bg21.png' => 'Background 21 (Gradient)',
            'assets/img/photos/bg22.png' => 'Background 22 (Gradient)',
            'assets/img/photos/bg23.png' => 'Background 23 (Gradient)',
            'assets/img/photos/bg24.png' => 'Background 24 (Gradient)',
            'assets/img/photos/bg25.png' => 'Background 25 (Gradient)',
        ];
        
        return $backgrounds;
    }

    public static function make(): Section
    {
        $languages = Language::active()->ordered()->get();
        $iconOptions = self::getIconOptions();
        $backgroundOptions = self::getBackgroundOptions();

        return Section::make(__('products.landing_page_section'))
            ->schema([
                // Hero Section
                Section::make(__('products.hero_section'))
                    ->schema([
                        TextInput::make('landing_page_data.hero.slogan')
                            ->label(__('products.hero_slogan'))
                            ->columnSpanFull(),
                        Textarea::make('landing_page_data.hero.sub_slogan')
                            ->label(__('products.hero_sub_slogan'))
                            ->rows(2)
                            ->columnSpanFull(),
                        Select::make('landing_page_data.hero.background_image')
                            ->label(__('products.hero_background_image'))
                            ->options($backgroundOptions)
                            ->searchable()
                            ->placeholder(__('products.select_background'))
                            ->helperText(__('products.hero_background_image_helper'))
                            ->columnSpanFull(),
                        TextInput::make('landing_page_data.hero.app_store_link')
                            ->label(__('products.app_store_link'))
                            ->url()
                            ->placeholder('https://apps.apple.com/...'),
                        TextInput::make('landing_page_data.hero.google_play_link')
                            ->label(__('products.google_play_link'))
                            ->url()
                            ->placeholder('https://play.google.com/...'),
                        FileUpload::make('landing_page_data.hero.featured_image')
                            ->label(__('products.hero_featured_image'))
                            ->image()
                            ->disk('public')
                            ->directory('products/landing')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),

                // App Features Section
                Section::make(__('products.app_features_section'))
                    ->schema([
                        Repeater::make('landing_page_data.features')
                            ->label(__('products.features'))
                            ->schema([
                                Select::make('icon')
                                    ->label(__('products.feature_icon'))
                                    ->options($iconOptions)
                                    ->searchable()
                                    ->required(),
                                TextInput::make('title')
                                    ->label(__('products.feature_title'))
                                    ->required()
                                    ->columnSpanFull(),
                                Textarea::make('description')
                                    ->label(__('products.feature_description'))
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->defaultItems(0)
                            ->addActionLabel(__('products.add_feature'))
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? __('products.feature') . ' #' . ($state['_index'] ?? ''))
                            ->columnSpanFull(),

                        // Note: Translations should match the order of features above
                        // Each feature translation array index should correspond to the feature index
                    ])
                    ->collapsible()
                    ->collapsed(),

                // How It Works Section
                Section::make(__('products.how_it_works_section'))
                    ->schema([
                        FileUpload::make('landing_page_data.how_it_works.download_image')
                            ->label(__('products.how_it_works_image'))
                            ->image()
                            ->disk('public')
                            ->directory('products/landing')
                            ->columnSpanFull(),
                        TextInput::make('landing_page_data.how_it_works.download_form_label')
                            ->label(__('products.download_form_label'))
                            ->placeholder(__('products.download_form_label_placeholder'))
                            ->columnSpanFull(),
                        
                        // Steps (4 steps with translations)
                        Repeater::make('landing_page_data.how_it_works.steps')
                            ->label(__('products.steps'))
                            ->schema([
                                TextInput::make('number')
                                    ->label(__('products.step_number'))
                                    ->numeric()
                                    ->default(fn ($get) => ($get('../../../_index') ?? 0) + 1)
                                    ->required(),
                                TextInput::make('title')
                                    ->label(__('products.step_title'))
                                    ->required()
                                    ->columnSpanFull(),
                                Textarea::make('description')
                                    ->label(__('products.step_description'))
                                    ->rows(2)
                                    ->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->defaultItems(4)
                            ->minItems(4)
                            ->maxItems(4)
                            ->reorderable(false)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => __('products.step') . ' ' . ($state['number'] ?? '') . ': ' . ($state['title'] ?? ''))
                            ->columnSpanFull(),

                        // Note: Steps translations should match the order of steps above
                        // Each step translation array index should correspond to the step index
                    ])
                    ->collapsible()
                    ->collapsed(),

                // Video Section
                Section::make(__('products.video_section'))
                    ->schema([
                        TextInput::make('landing_page_data.video.youtube_video_id')
                            ->label(__('products.youtube_video_id'))
                            ->placeholder('165101721')
                            ->helperText(__('products.youtube_video_id_helper'))
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                // FAQ Section
                Section::make(__('products.faq_section'))
                    ->schema([
                        Repeater::make('landing_page_data.faqs')
                            ->label(__('products.faqs'))
                            ->schema([
                                TextInput::make('question')
                                    ->label(__('products.faq_question'))
                                    ->required()
                                    ->columnSpanFull(),
                                Textarea::make('answer')
                                    ->label(__('products.faq_answer'))
                                    ->rows(3)
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->defaultItems(0)
                            ->addActionLabel(__('products.add_faq'))
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['question'] ?? __('products.faq') . ' #' . ($state['_index'] ?? ''))
                            ->columnSpanFull(),

                        // Note: FAQ translations should match the order of FAQs above
                        // Each FAQ translation array index should correspond to the FAQ index
                    ])
                    ->collapsible()
                    ->collapsed(),
            ])
            ->visible(fn (Get $get) => $get('type') === 'product')
            ->columnSpanFull();
    }
}

