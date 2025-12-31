<?php

namespace App\Filament\Admin\Resources\SiteTranslations\Schemas;

use App\Models\Language;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteTranslationForm
{
    public static function make(Schema $schema): Schema
    {
        $languages = Language::where('is_active', true)->get();
        
        $translationFields = [];
        foreach ($languages as $language) {
            $translationFields[] = Textarea::make($language->code)
                ->label($language->name . " ({$language->code})")
                ->rows(2);
        }

        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Textarea::make('key')
                            ->label('Key / Original Text')
                            ->required()
                            ->columnSpanFull()
                            ->helperText('The original text to be translated. Use this exact text in t() helper.'),

                        Group::make()
                            ->schema($translationFields)
                            ->statePath('translations')
                            ->columnSpanFull(),
                    ])
            ]);
    }
}



