<?php

namespace App\Filament\Admin\Resources\Settings\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('settings.title'))
                    ->schema([
                        TextInput::make('key')
                            ->label(__('settings.key'))
                            ->helperText(__('settings.key_helper'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->regex('/^[a-z0-9_-]+$/')
                            ->maxLength(255)
                            ->disabled(fn ($record) => $record !== null)
                            ->columnSpanFull(),

                        TextInput::make('label')
                            ->label(__('settings.label'))
                            ->helperText(__('settings.label_helper'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label(__('settings.description'))
                            ->helperText(__('settings.description_helper'))
                            ->rows(3)
                            ->columnSpanFull(),

                        Select::make('type')
                            ->label(__('settings.type'))
                            ->helperText(__('settings.type_helper'))
                            ->required()
                            ->options([
                                'string' => __('settings.type_string'),
                                'text' => __('settings.type_text'),
                                'boolean' => __('settings.type_boolean'),
                                'integer' => __('settings.type_integer'),
                                'float' => __('settings.type_float'),
                                'array' => __('settings.type_array'),
                                'json' => __('settings.type_json'),
                                'file' => __('settings.type_file'),
                                'date' => __('settings.type_date'),
                                'datetime' => __('settings.type_datetime'),
                            ])
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('value', null)),

                        Select::make('group')
                            ->label(__('settings.group'))
                            ->helperText(__('settings.group_helper'))
                            ->required()
                            ->options([
                                'general' => __('settings.group_general'),
                                'email' => __('settings.group_email'),
                                'seo' => __('settings.group_seo'),
                                'social' => __('settings.group_social'),
                                'security' => __('settings.group_security'),
                                'payment' => __('settings.group_payment'),
                                'notification' => __('settings.group_notification'),
                                'other' => __('settings.group_other'),
                            ])
                            ->default('general'),

                        Textarea::make('value_text')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => !in_array($get('type'), ['boolean', 'file', 'date', 'datetime', 'array']))
                            ->rows(fn (Get $get) => $get('type') === 'text' ? 5 : 3)
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && !in_array($record->type, ['boolean', 'file', 'date', 'datetime', 'array'])) {
                                    return $record->value;
                                }
                                return $state;
                            })
                            ->columnSpanFull(),

                        Toggle::make('value_boolean')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'boolean')
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'boolean') {
                                    return filter_var($record->value, FILTER_VALIDATE_BOOLEAN);
                                }
                                return false;
                            })
                            ->columnSpanFull(),

                        FileUpload::make('value_file')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'file')
                            ->disk('public')
                            ->directory('settings')
                            ->acceptedFileTypes(['image/*', 'application/pdf', 'text/*'])
                            ->maxSize(10240) // 10MB
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'file') {
                                    return $record->value;
                                }
                                return $state;
                            })
                            ->columnSpanFull(),

                        DatePicker::make('value_date')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'date')
                            ->displayFormat('d/m/Y')
                            ->format('Y-m-d')
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'date') {
                                    return $record->value;
                                }
                                return $state;
                            })
                            ->columnSpanFull(),

                        DateTimePicker::make('value_datetime')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'datetime')
                            ->displayFormat('d/m/Y H:i')
                            ->format('Y-m-d H:i:s')
                            ->seconds(false)
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'datetime') {
                                    return $record->value;
                                }
                                return $state;
                            })
                            ->columnSpanFull(),

                        Repeater::make('value_array')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'array')
                            ->schema([
                                TextInput::make('key')
                                    ->label(__('settings.array_key'))
                                    ->required()
                                    ->placeholder(__('settings.array_key_placeholder')),
                                TextInput::make('value')
                                    ->label(__('settings.array_value'))
                                    ->required()
                                    ->placeholder(__('settings.array_value_placeholder')),
                                Textarea::make('description')
                                    ->label(__('settings.array_description'))
                                    ->placeholder(__('settings.array_description_placeholder'))
                                    ->rows(2),
                                Toggle::make('active')
                                    ->label(__('settings.array_active'))
                                    ->default(true),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->addActionLabel(__('settings.array_add_item'))
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['key'] ?? null)
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'array') {
                                    $decoded = json_decode($record->value, true);
                                    return is_array($decoded) ? $decoded : [];
                                }
                                return is_array($state) ? $state : [];
                            })
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label(__('settings.is_active'))
                            ->helperText(__('settings.is_active_helper'))
                            ->default(true)
                            ->columnSpan(1),

                        Toggle::make('is_public')
                            ->label(__('settings.is_public'))
                            ->helperText(__('settings.is_public_helper'))
                            ->default(false)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }
}
