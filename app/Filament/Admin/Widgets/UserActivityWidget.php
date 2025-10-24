<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UserActivityWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->with('roles')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('dashboard.user_activity.username'))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label(__('dashboard.user_activity.email'))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('roles.name')
                    ->label(__('dashboard.user_activity.role'))
                    ->badge()
                    ->color('primary'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('dashboard.user_activity.created_at'))
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label(__('dashboard.user_activity.email_verified'))
                    ->dateTime()
                    ->sortable()
                    ->placeholder(__('dashboard.user_activity.unverified')),
            ])
            ->heading(__('dashboard.widgets.user_activity.title'))
            ->paginated(false);
    }
}

