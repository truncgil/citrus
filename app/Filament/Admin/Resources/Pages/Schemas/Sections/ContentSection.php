<?php

namespace App\Filament\Admin\Resources\Pages\Schemas\Sections;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class ContentSection
{
    public static function make(): Section
    {
        return Section::make(__('pages.form_section_content'))
            ->schema([
                TextInput::make('title')
                    ->label(__('pages.title_field'))
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, callable $set) {
                        if ($operation !== 'create') {
                            return;
                        }
                        $set('slug', \Str::slug($state));
                    }),
                
                TextInput::make('slug')
                    ->label(__('pages.slug_field'))
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->rules(['alpha_dash'])
                    ->helperText(__('pages.slug_helper_text')),
                
                RichEditor::make('content')
                    ->label(__('pages.content_field'))
                    ->required()
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsDirectory('pages')
                    ->fileAttachmentsVisibility('public')
                    ->columnSpanFull(),
                
                Textarea::make('excerpt')
                    ->label(__('pages.excerpt_field'))
                    ->rows(3)
                    ->maxLength(500)
                    ->helperText(__('pages.excerpt_helper_text'))
                    ->columnSpanFull(),
            ])
            ->columnSpan(2)
            ->collapsible(false);
    }
}

