<?php

namespace App\Filament\Imports;

use App\Models\SiteTranslation;
use App\Models\Language;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class SiteTranslationImporter extends Importer
{
    protected static ?string $model = SiteTranslation::class;

    public static function getColumns(): array
    {
        $columns = [
            ImportColumn::make('key')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];

        try {
            $languages = Language::where('is_active', true)->get();
            foreach ($languages as $language) {
                $columns[] = ImportColumn::make($language->code)
                    ->label($language->name . " ({$language->code})");
            }
        } catch (\Exception $e) {
            //
        }

        return $columns;
    }

    public function resolveRecord(): ?SiteTranslation
    {
        return SiteTranslation::firstOrNew([
            'key' => $this->data['key'],
        ]);
    }

    protected function beforeSave(): void
    {
        $translations = $this->record->translations ?? [];
        
        // CSV'den gelen verileri al (data array içinde mapped column adları ile gelir)
        // getColumns'da column adlarını dil kodu olarak verdik: $language->code
        
        $languages = Language::where('is_active', true)->pluck('code')->toArray();

        foreach ($languages as $code) {
            if (isset($this->data[$code])) {
                // Boş string gelse bile güncelleyelim mi? Evet, çeviri silinmiş olabilir.
                // Ancak null gelirse (CSV'de sütun yoksa) dokunmayalım.
                // ImportColumn boş hücreleri null veya boş string olarak getirebilir.
                
                $value = $this->data[$code];
                
                if ($value !== null) {
                     $translations[$code] = $value;
                }
            }
        }
        
        $this->record->translations = $translations;
        
        if (!$this->record->exists && empty($this->record->hash)) {
             $this->record->hash = md5($this->record->key);
        }
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your site translation import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}

