<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Page;
use App\Models\Translation;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivitiesWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Page::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('dashboard.activities.recent_pages'))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'gray',
                        'review' => 'warning',
                        default => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('dashboard.user_activity.created_at'))
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('author.name')
                    ->label(__('dashboard.activities.creator'))
                    ->sortable(),
            ])
            ->heading(__('dashboard.activities.recent_pages'))
            ->paginated(false);
    }
}
