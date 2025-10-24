<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Language;
use App\Models\Translation;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TranslationProgressWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Language::query()
                    ->where('is_active', true)
                    ->withCount([
                        'translations as total_translations',
                        'translations as published_translations' => function ($query) {
                            $query->where('status', 'published');
                        },
                        'translations as draft_translations' => function ($query) {
                            $query->where('status', 'draft');
                        },
                    ])
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('dashboard.translation_progress.language'))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('native_name')
                    ->label(__('dashboard.translation_progress.native_name'))
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('total_translations')
                    ->label(__('dashboard.translation_progress.total_fields'))
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('published_translations')
                    ->label(__('dashboard.translation_progress.translated_fields'))
                    ->numeric()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('progress_percentage')
                    ->label(__('dashboard.translation_progress.progress_percentage'))
                    ->getStateUsing(function ($record) {
                        if ($record->total_translations == 0) {
                            return '0%';
                        }
                        $percentage = round(($record->published_translations / $record->total_translations) * 100);
                        return $percentage . '%';
                    })
                    ->badge()
                    ->color(function (string $state): string {
                        $percentage = (int) str_replace('%', '', $state);
                        if ($percentage >= 80) {
                            return 'success';
                        } elseif ($percentage >= 50) {
                            return 'warning';
                        } else {
                            return 'danger';
                        }
                    }),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('dashboard.translation_progress.active'))
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('is_default')
                    ->label(__('dashboard.translation_progress.default'))
                    ->boolean(),
            ])
            ->heading(__('dashboard.widgets.translation_progress.title'))
            ->paginated(false);
    }
}
