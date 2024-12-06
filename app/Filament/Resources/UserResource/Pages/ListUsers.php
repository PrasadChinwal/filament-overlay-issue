<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Actions\CreateUserFromActiveDirectoryAction;
use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle'),
            Actions\Action::make('Fill')
                ->label('Create User from AD')
                ->icon('heroicon-o-plus-circle')
                ->model(User::class)
                ->form([
                    TextInput::make('name')
                        ->requiredWithout('email'),
                    TextInput::make('email')
                        ->requiredWithout('name'),
                ])
                ->action(function ($data) {
                    dd($data);
                    User::updateOrCreate(
                        ['email' => $adUser->email],
                        [
                            'name' => $adUser->full_name,
                            'first_name' => $adUser->first_name,
                            'last_name' => $adUser->last_name,
                            'netid' => $adUser->netid,
                            'uin' => $adUser->uin,
                            'password' => Hash::make('P@ssw0rd'),
                        ]
                    );
                }),
        ];
    }
}
