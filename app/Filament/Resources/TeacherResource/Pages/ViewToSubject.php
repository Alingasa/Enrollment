<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\SubjectResource;
use App\Filament\Resources\TeacherResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewToSubject extends ViewRecord
{
    protected static string $resource = SubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
            ->color('warning')
            ->icon('heroicon-o-pencil-square'),
        ];
    }
}
