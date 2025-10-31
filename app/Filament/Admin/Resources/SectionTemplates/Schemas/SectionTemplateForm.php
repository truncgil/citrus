<?php

namespace App\Filament\Admin\Resources\SectionTemplates\Schemas;

use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SectionTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('section-templates.section_general'))
                    ->schema([
                        TextInput::make('title')
                            ->label(__('section-templates.field_title'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        CodeEditor::make('html_content')
                            ->label(__('section-templates.field_html_content'))
                            ->required()
                            ->lineNumbers()
                            ->columnSpanFull()
                            ->helperText(__('section-templates.field_html_content_help')),

                        Toggle::make('is_active')
                            ->label(__('section-templates.field_is_active'))
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2),
            ]);
    }
}
