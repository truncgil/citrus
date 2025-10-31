<?php

namespace App\Filament\Admin\Resources\FooterTemplates\Schemas;

use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;

class FooterTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('footer-templates.section_general'))
                    ->schema([
                        TextInput::make('title')
                            ->label(__('footer-templates.field_title'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        CodeEditor::make('html_content')
                            ->label(__('footer-templates.field_html_content'))
                            ->required()
                            ->live(onBlur: false) // Real-time updates
                            ->columnSpanFull()
                            ->helperText(__('footer-templates.field_html_content_help'))
                            ->extraAttributes([
                                'style' => 'min-height: 400px;',
                                'data-field-name' => 'html_content',
                            ]),

                        // Preview Component - placed after editor
                        View::make('components.template-preview')
                            ->extraAttributes([
                                'data-type' => 'footer',
                                'data-field-name' => 'html_content',
                            ])
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label(__('footer-templates.field_is_active'))
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
