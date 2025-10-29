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
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\CodeEditor\Enums\Language as CodeEditorLanguage;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\KeyValue;
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
                                'color_picker' => __('settings.type_color_picker'),
                                'code_editor' => __('settings.type_code_editor'),
                                'rich_editor' => __('settings.type_rich_editor'),
                                'markdown_editor' => __('settings.type_markdown_editor'),
                                'tags_input' => __('settings.type_tags_input'),
                                'checkbox_list' => __('settings.type_checkbox_list'),
                                'radio' => __('settings.type_radio'),
                                'toggle_buttons' => __('settings.type_toggle_buttons'),
                                'slider' => __('settings.type_slider'),
                                'key_value' => __('settings.type_key_value'),
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
                            ->visible(fn (Get $get) => in_array($get('type'), ['string', 'text', 'json']))
                            ->rows(fn (Get $get) => $get('type') === 'text' ? 5 : 3)
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && in_array($record->type, ['string', 'text', 'json'])) {
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

                        ColorPicker::make('value_color_picker')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'color_picker')
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'color_picker') {
                                    return $record->value;
                                }
                                return $state;
                            })
                            ->columnSpanFull(),

                        CodeEditor::make('value_code_editor')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'code_editor')
                            ->language(CodeEditorLanguage::Php)
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'code_editor') {
                                    return $record->value;
                                }
                                return $state;
                            })
                            ->columnSpanFull(),

                        RichEditor::make('value_rich_editor')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'rich_editor')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('settings')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'rich_editor') {
                                    return $record->value;
                                }
                                return $state;
                            })
                            ->columnSpanFull(),

                        MarkdownEditor::make('value_markdown_editor')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'markdown_editor')
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'markdown_editor') {
                                    return $record->value;
                                }
                                return $state;
                            })
                            ->columnSpanFull(),

                        TagsInput::make('value_tags_input')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'tags_input')
                            ->separator(',')
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'tags_input') {
                                    $decoded = json_decode($record->value, true);
                                    return is_array($decoded) ? $decoded : [];
                                }
                                return is_array($state) ? $state : [];
                            })
                            ->columnSpanFull(),

                        CheckboxList::make('value_checkbox_list')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'checkbox_list')
                            ->options(fn () => [
                                'option1' => __('settings.checkbox_option_1'),
                                'option2' => __('settings.checkbox_option_2'),
                                'option3' => __('settings.checkbox_option_3'),
                            ])
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'checkbox_list') {
                                    $decoded = json_decode($record->value, true);
                                    return is_array($decoded) ? $decoded : [];
                                }
                                return is_array($state) ? $state : [];
                            })
                            ->columnSpanFull(),

                        Radio::make('value_radio')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'radio')
                            ->options(fn () => [
                                'option1' => __('settings.radio_option_1'),
                                'option2' => __('settings.radio_option_2'),
                                'option3' => __('settings.radio_option_3'),
                            ])
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'radio') {
                                    return $record->value;
                                }
                                return $state;
                            })
                            ->columnSpanFull(),

                        ToggleButtons::make('value_toggle_buttons')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'toggle_buttons')
                            ->options(fn () => [
                                'option1' => __('settings.toggle_option_1'),
                                'option2' => __('settings.toggle_option_2'),
                                'option3' => __('settings.toggle_option_3'),
                            ])
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'toggle_buttons') {
                                    return $record->value;
                                }
                                return $state;
                            })
                            ->columnSpanFull(),

                        Slider::make('value_slider')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'slider')
                            ->range(minValue: 0, maxValue: 100)
                            ->step(1)
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'slider') {
                                    return (int) $record->value;
                                }
                                return $state ?? 0;
                            })
                            ->columnSpanFull(),

                        KeyValue::make('value_key_value')
                            ->label(__('settings.value'))
                            ->helperText(__('settings.value_helper'))
                            ->required()
                            ->visible(fn (Get $get) => $get('type') === 'key_value')
                            ->formatStateUsing(function ($state, $record) {
                                if ($record && $record->type === 'key_value') {
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
