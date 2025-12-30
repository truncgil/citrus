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
                ->label('Key')
                ->requiredMapping()
                ->rules(['required']),
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
        if (empty($this->data['key'])) {
            return null;
        }

        // Key üzerinden kaydı bul veya yeni oluştur
        // Not: key alanı text olduğu için tam eşleşme arıyoruz
        return SiteTranslation::firstOrNew([
            'key' => $this->data['key'],
        ]);
    }

    protected function beforeSave(): void
    {
        $translations = $this->record->translations ?? [];
        
        $languages = Language::where('is_active', true)->pluck('code')->toArray();

        foreach ($languages as $code) {
            if (array_key_exists($code, $this->data)) {
                $value = $this->data[$code];
                
                // Boş string de olsa güncelleyelim, null ise (CSV'de yoksa) dokunmayalım
                if ($value !== null) {
                     $translations[$code] = $value;
                }
            }
        }
        
        $this->record->translations = $translations;
        
        // Hash'i manuel oluşturmaya gerek yok, model event'i halledecek ama 
        // new record ise ve event çalışmazsa diye garantiye alalım (import toplu insert yapabilir mi? Hayır record record işler)
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
