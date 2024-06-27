<?php

namespace App\Filament\Teacher\Resources\SubjectResource\Pages;

use App\Filament\Teacher\Resources\SubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubjects extends ListRecords
{
    protected static string $resource = SubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\Action::make('print')
            ->url(fn() => route('download.allsubjects'))
            ->openUrlInNewTab()
            ->label('Print')
            ->icon('heroicon-o-printer')
            ->color('danger'),
        ];
    }
}
