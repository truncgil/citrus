<?php

namespace App\Filament\Exports;

use App\Models\SiteTranslation;
use App\Models\Language;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class SiteTranslationExporter extends Exporter
{
    protected static ?string $model = SiteTranslation::class;

    public static function getColumns(): array
    {
        $columns = [
            ExportColumn::make('key')->label('Key'),
        ];

        // Veritabanı bağlantısı yoksa veya tablo yoksa hata vermemesi için try-catch veya kontrol
        try {
            $languages = Language::where('is_active', true)->get();
            foreach ($languages as $language) {
                $columns[] = ExportColumn::make("translations.{$language->code}")
                    ->label($language->name . " ({$language->code})");
            }
        } catch (\Exception $e) {
            // Migration henüz çalışmadıysa
        }

        return $columns;
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your site translation export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

