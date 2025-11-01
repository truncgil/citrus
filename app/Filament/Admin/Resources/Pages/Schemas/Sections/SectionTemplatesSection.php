<?php

namespace App\Filament\Admin\Resources\Pages\Schemas\Sections;

use App\Models\SectionTemplate;
use App\Services\TemplateService;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class SectionTemplatesSection
{
    public static function make(): Section
    {
        return Section::make(__('pages.form_section_template_sections'))
            ->description(__('pages.form_section_template_sections_desc'))
            ->schema([
                Repeater::make('sections_data')
                    ->label(__('pages.template_sections_field'))
                    ->schema([
                        Select::make('section_template_id')
                            ->label(__('pages.section_template_field'))
                            ->options(SectionTemplate::where('is_active', true)->pluck('title', 'id'))
                            ->searchable()
                            ->live()
                            ->required()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                if (!$state) {
                                    return;
                                }
                                
                                $template = SectionTemplate::find($state);
                                if (!$template) {
                                    return;
                                }
                                
                                $defaultData = $template->default_data;
                                if (is_string($defaultData)) {
                                    $defaultData = json_decode($defaultData, true) ?? [];
                                }
                                if (!is_array($defaultData) || empty($defaultData)) {
                                    return;
                                }
                                
                                $existingData = $get('section_data') ?? [];
                                
                                $flattenDefaultData = function ($array, $prefix = '') use (&$flattenDefaultData) {
                                    $result = [];
                                    foreach ($array as $key => $value) {
                                        $newKey = $prefix ? "{$prefix}.{$key}" : $key;
                                        if (is_array($value)) {
                                            $result = array_merge($result, $flattenDefaultData($value, $newKey));
                                        } else {
                                            $result[$newKey] = $value;
                                        }
                                    }
                                    return $result;
                                };
                                
                                $flattenedDefaults = $flattenDefaultData($defaultData);
                                
                                foreach ($flattenedDefaults as $key => $defaultValue) {
                                    $keys = explode('.', $key);
                                    $currentValue = $existingData;
                                    
                                    foreach ($keys as $k) {
                                        $currentValue = $currentValue[$k] ?? null;
                                        if ($currentValue === null) {
                                            break;
                                        }
                                    }
                                    
                                    if ($currentValue === null || 
                                        $currentValue === '' || 
                                        (is_array($currentValue) && empty($currentValue))) {
                                        $set("section_data.{$key}", $defaultValue);
                                    }
                                }
                            })
                            ->columnSpanFull(),
                        
                        Group::make()
                            ->schema(function (Get $get, $state): array {
                                $templateId = $get('section_template_id');
                                if (!$templateId) {
                                    return [];
                                }
                                
                                $template = SectionTemplate::find($templateId);
                                if (!$template) {
                                    return [];
                                }
                                
                                $existingData = $get('section_data') ?? [];
                                $templateDefaults = $template->default_data ?? [];
                                
                                return TemplateService::generateDynamicFields(
                                    $template,
                                    'section_data',
                                    $existingData,
                                    $templateDefaults
                                );
                            })
                            ->visible(fn (Get $get): bool => filled($get('section_template_id')))
                            ->columnSpanFull(),
                    ])
                    ->defaultItems(0)
                    ->addActionLabel(__('pages.add_template_section'))
                    ->reorderable()
                    ->collapsible()
                    ->collapsed()
                    ->itemLabel(__('pages.template_section'))
                    ->columnSpanFull(),
            ])
            ->columnSpanFull()
            ->collapsible(true)
            ->collapsed(true);
    }
}

