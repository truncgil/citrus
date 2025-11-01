<?php

namespace App\Filament\Admin\Resources\HeaderTemplates\Schemas;

use App\Models\HeaderTemplate;
use App\Services\TemplateService;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Forms\Components\CodeEditor\Enums\Language;

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
                            ->live(onBlur: true) // Real-time updates
                            ->language(Language::Html)
                            ->columnSpanFull()
                            ->helperText(__('header-templates.field_html_content_help'))
                            ->extraAttributes([
                                'style' => 'max-height: 400px;overflow-y: auto;',
                                'data-field-name' => 'html_content',
                            ]),

                        // Preview Component - placed after editor
                        View::make('components.template-preview')
                            ->viewData([
                                'type' => 'header',
                                'fieldName' => 'html_content',
                            ])
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label(__('header-templates.field_is_active'))
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columnSpanFull(),
                
                // Default Data Section - Dynamic fields based on placeholders
                Section::make(__('header-templates.section_default_data'))
                    ->description(__('header-templates.section_default_data_desc'))
                    ->schema([
                        Group::make()
                            ->schema(function (Get $get, $record): array {
                                $htmlContent = $get('html_content');
                                if (empty($htmlContent)) {
                                    return [];
                                }
                                
                                // Create a temporary template object to parse placeholders
                                $tempTemplate = new HeaderTemplate();
                                $tempTemplate->html_content = $htmlContent;
                                
                                // Get existing default_data if editing
                                $existingData = $record ? ($record->default_data ?? []) : [];
                                
                                return TemplateService::generateDynamicFields(
                                    $tempTemplate,
                                    'default_data',
                                    $existingData,
                                    null // No fallback needed for template's own default_data
                                );
                            })
                            ->key('default_data_fields')
                            ->visible(fn (Get $get): bool => filled($get('html_content')))
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->collapsible(true)
                    ->collapsed(false),
            ]);
    }
}
