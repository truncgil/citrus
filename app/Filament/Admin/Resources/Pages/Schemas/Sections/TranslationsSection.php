<?php

namespace App\Filament\Admin\Resources\Pages\Schemas\Sections;

use App\Filament\Admin\Resources\Components\TranslationTabs;
use Filament\Schemas\Components\Section;

class TranslationsSection
{
    public static function make(): Section
    {
        return Section::make('🌍 ' . __('pages.translations_section'))
            ->schema([
                TranslationTabs::make([
                    'title' => [
                        'type' => 'text',
                        'label' => __('pages.title_field'),
                        'required' => false,
                        'maxLength' => 255,
                    ],
                    'content' => [
                        'type' => 'richtext',
                        'label' => __('pages.content_field'),
                        'required' => false,
                    ],
                    'excerpt' => [
                        'type' => 'textarea',
                        'label' => __('pages.excerpt_field'),
                        'required' => false,
                        'maxLength' => 500,
                        'rows' => 3,
                    ],
                    'meta_title' => [
                        'type' => 'text',
                        'label' => __('pages.meta_title_field'),
                        'required' => false,
                        'maxLength' => 60,
                    ],
                    'meta_description' => [
                        'type' => 'textarea',
                        'label' => __('pages.meta_description_field'),
                        'required' => false,
                        'maxLength' => 160,
                        'rows' => 3,
                    ],
                ]),
            ])
            ->columnSpanFull()
            ->collapsible(true)
            ->collapsed(false);
    }
}

