<?php

namespace App\Filament\Admin\Resources\HeaderTemplates\Schemas;

use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HeaderTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('header-templates.section_general'))
                    ->schema([
                        TextInput::make('title')
                            ->label(__('header-templates.field_title'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        CodeEditor::make('html_content')
                            ->label(__('header-templates.field_html_content'))
                            ->required()
                            ->lineNumbers()
                            ->columnSpanFull()
                            ->helperText(__('header-templates.field_html_content_help')),

                        Toggle::make('is_active')
                            ->label(__('header-templates.field_is_active'))
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2),
            ]);
    }
}
