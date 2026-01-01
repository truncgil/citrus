<?php

namespace App\Filament\Admin\Resources\Pages\Schemas\Sections;

use App\Models\HeaderTemplate;
use App\Services\TemplateService;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

use Illuminate\Support\Facades\File;

class HeaderTemplateSection
{
    public static function make(): Section
    {
        return Section::make(__('pages.form_section_header_template'))
            ->description(__('pages.form_section_header_template_desc'))
            ->schema([
                Select::make('custom_header_blade')
                    ->label('Custom Header Blade')
                    ->options(function () {
                        $files = File::glob(resource_path('views/partials/*.blade.php'));
                        $options = [];
                        foreach ($files as $file) {
                            $name = basename($file, '.blade.php');
                            $options["partials.{$name}"] = "Partial: {$name}";
                        }
                        
                        // Add other directories if needed
                        $componentFiles = File::glob(resource_path('views/components/front/*.blade.php'));
                        foreach ($componentFiles as $file) {
                             $name = basename($file, '.blade.php');
                             $options["components.front.{$name}"] = "Component: {$name}";
                        }
                        
                        return $options;
                    })
                    ->searchable()
                    ->preload()
                    ->helperText('Select a physical Blade file to use as header instead of a database template.')
                    ->live()
                    ->columnSpanFull(),

                Select::make('header_template_id')
                    ->label(__('pages.header_template_field'))
                    ->options(HeaderTemplate::where('is_active', true)->pluck('title', 'id'))
                    ->visible(fn (Get $get) => empty($get('custom_header_blade')))
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                        if (!$state) {
                            return;
                        }
                        
                        $template = HeaderTemplate::find($state);
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
                        
                        $existingData = $get('header_data') ?? [];
                        
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
                                $set("header_data.{$key}", $defaultValue);
                            }
                        }
                    })
                    ->columnSpanFull(),
                
                Group::make()
                    ->schema(function (Get $get, $record): array {
                        $templateId = $get('header_template_id');
                        if (!$templateId) {
                            return [];
                        }
                        
                        $template = HeaderTemplate::find($templateId);
                        if (!$template) {
                            return [];
                        }
                        
                        $existingData = $record?->header_data ?? [];
                        $templateDefaults = $template->default_data ?? [];
                        
                        return TemplateService::generateDynamicFields(
                            $template,
                            'header_data',
                            $existingData,
                            $templateDefaults
                        );
                    })
                    ->visible(fn (Get $get): bool => filled($get('header_template_id')))
                    ->columnSpanFull(),
            ])
            ->columnSpanFull()
            ->collapsible(true)
            ->collapsed(true);
    }
}

