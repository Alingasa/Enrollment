<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\EnrollmentResource;
use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStudent extends ViewRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
            ->label('Edit')
            ->color('warning')
            ->icon('heroicon-o-pencil-square'),
        ];
    }
}