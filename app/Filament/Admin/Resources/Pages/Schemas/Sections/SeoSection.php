<?php

namespace App\Filament\Admin\Resources\Pages\Schemas\Sections;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class SeoSection
{
    public static function make(): Section
    {
        return Section::make(__('pages.form_section_seo_settings'))
            ->schema([
                TextInput::make('meta_title')
                    ->label(__('pages.meta_title_field'))
                    ->maxLength(60)
                    ->helperText(__('pages.meta_title_helper_text')),
                
                Textarea::make('meta_description')
                    ->label(__('pages.meta_description_field'))
                    ->rows(3)
                    ->maxLength(160)
                    ->helperText(__('pages.meta_description_helper_text'))
                    ->columnSpanFull(),
            ])
            ->columns(2)
            ->columnSpanFull()
            ->collapsible(true)
            ->collapsed(true);
    }
}

