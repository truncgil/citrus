<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserActions
{
    public static function make(): array
    {
        return [
            EditAction::make()
                ->label('')
                ->tooltip(__('users.edit'))
                ->visible(fn () => Auth::user()?->can('Update:User')),
            
            Action::make('change_password')
                ->label('')
                ->tooltip(__('users.change_password'))
                ->icon('heroicon-o-key')
                ->color('warning')
                ->form([
                    TextInput::make('password')
                        ->label(__('users.password'))
                        ->password()
                        ->required()
                        ->confirmed(),
                    TextInput::make('password_confirmation')
                        ->label(__('users.password_confirmation'))
                        ->password()
                        ->required(),
                ])
                ->action(function ($record, array $data) {
                    $record->update([
                        'password' => Hash::make($data['password']),
                    ]);
                    
                    Notification::make()
                        ->title(__('users.password_changed_successfully'))
                        ->success()
                        ->send();
                })
                ->visible(fn () => Auth::user()?->can('Update:User')),
            
            DeleteAction::make()
                ->label('')
                ->tooltip(__('users.delete'))
                ->visible(fn () => Auth::user()?->can('Delete:User')),
        ];
    }
}
