<?php

namespace App\Filament\Admin\Resources\SectionTemplates\Schemas;

use App\Models\SectionTemplate;
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
                            ->live(onBlur: false) // Real-time updates
                            ->language(Language::Html)
                            ->columnSpanFull()
                            ->helperText(__('section-templates.field_html_content_help'))
                            ->extraAttributes([
                                'style' => 'max-height: 400px;overflow-y: auto;',
                                'data-field-name' => 'html_content',
                            ]),

                        // Preview Component - placed after editor
                        View::make('components.template-preview')
                            ->viewData(function ($record) {
                                return [
                                    'type' => 'section',
                                    'fieldName' => 'html_content',
                                    'recordId' => $record?->id,
                                ];
                            })
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label(__('section-templates.field_is_active'))
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columnSpanFull(),
                
                // Default Data Section - Dynamic fields based on placeholders
                Section::make(__('section-templates.section_default_data'))
                    ->description(__('section-templates.section_default_data_desc'))
                    ->schema([
                        Group::make()
                            ->schema(function (Get $get, $record): array {
                                $htmlContent = $get('html_content');
                                if (empty($htmlContent)) {
                                    return [];
                                }
                                
                                // Create a temporary template object to parse placeholders
                                $tempTemplate = new SectionTemplate();
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
