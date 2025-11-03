<?php

namespace App\Filament\Admin\Resources\HeaderTemplates\Pages;

use App\Filament\Admin\Resources\HeaderTemplates\HeaderTemplateResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateHeaderTemplate extends CreateRecord
{
    protected static string $resource = HeaderTemplateResource::class;

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::Full;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Transform nested default_data fields (e.g., default_data.color.bg) 
        // into proper array format
        $defaultData = [];
        
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'default_data.')) {
                // Remove 'default_data.' prefix to get the nested key
                $nestedKey = substr($key, 13); // 'default_data.' length is 13
                $defaultData[$nestedKey] = $value;
                // Remove the flattened key from data
                unset($data[$key]);
            }
        }
        
        // Set the properly formatted default_data array
        if (!empty($defaultData)) {
            $data['default_data'] = $defaultData;
        }
        
        return $data;
    }
}
