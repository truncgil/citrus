<?php

namespace App\Filament\Admin\Resources\Languages\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

class LanguageForm
{
    public static function schema(): array
    {
        return [
            Section::make(__('language.basic_information'))
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('code')
                            ->label(__('language.code'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(10)
                            ->placeholder('tr, en, de')
                            ->helperText(__('language.code_helper'))
                            ->columnSpan(1),

                        TextInput::make('flag')
                            ->label(__('language.flag'))
                            ->maxLength(10)
                            ->placeholder('🇹🇷')
                            ->helperText(__('language.flag_helper'))
                            ->columnSpan(1),
                    ]),

                    Grid::make(2)->schema([
                        TextInput::make('name')
                            ->label(__('language.name'))
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Turkish')
                            ->helperText(__('language.name_helper'))
                            ->columnSpan(1),

                        TextInput::make('native_name')
                            ->label(__('language.native_name'))
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Türkçe')
                            ->helperText(__('language.native_name_helper'))
                            ->columnSpan(1),
                    ]),

                    Grid::make(2)->schema([
                        Select::make('direction')
                            ->label(__('language.direction'))
                            ->options([
                                'ltr' => __('language.direction_ltr'),
                                'rtl' => __('language.direction_rtl'),
                            ])
                            ->default('ltr')
                            ->required()
                            ->columnSpan(1),

                        TextInput::make('sort_order')
                            ->label(__('language.sort_order'))
                            ->numeric()
                            ->default(0)
                            ->helperText(__('language.sort_order_helper'))
                            ->columnSpan(1),
                    ]),
                ]),

            Section::make(__('language.settings'))
                ->schema([
                    Grid::make(3)->schema([
                        Checkbox::make('is_active')
                            ->label(__('language.is_active'))
                            ->default(true)
                            ->helperText(__('language.is_active_helper'))
                            ->columnSpan(1),

                        Checkbox::make('is_default')
                            ->label(__('language.is_default'))
                            ->default(false)
                            ->helperText(__('language.is_default_helper'))
                            ->columnSpan(1)
                            ->disabled(fn ($record) => $record && $record->is_default),
                    ]),
                ]),
        ];
    }
}

