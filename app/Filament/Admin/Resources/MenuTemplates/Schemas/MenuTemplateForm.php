<?php

namespace App\Filament\Admin\Resources\MenuTemplates\Schemas;

use App\Models\MenuTemplate;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Forms\Components\CodeEditor\Enums\Language;

class MenuTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('menu-templates.section_general'))
                    ->schema([
                        TextInput::make('title')
                            ->label(__('menu-templates.field_title'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        // Placeholder Picker Component
                        View::make('components.placeholder-picker')
                            ->viewData([
                                'fieldName' => 'html_content',
                            ])
                            ->columnSpanFull(),

                        CodeEditor::make('html_content')
                            ->label(__('menu-templates.field_html_content'))
                            ->required()
                            ->live(onBlur: true)
                            ->language(Language::Html)
                            ->columnSpanFull()
                            ->helperText(__('menu-templates.field_html_content_help'))
                            ->extraAttributes([
                                'style' => 'max-height: 400px;overflow-y: auto;',
                                'data-field-name' => 'html_content',
                            ]),

                        // Preview Component
                        View::make('components.menu-template-preview')
                            ->viewData([
                                'type' => 'menu',
                                'fieldName' => 'html_content',
                                'recordId' => null, // Will be extracted from URL by JavaScript
                            ])
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label(__('menu-templates.field_is_active'))
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
