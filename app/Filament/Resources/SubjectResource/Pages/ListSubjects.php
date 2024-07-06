<?php

namespace App\Filament\Resources\SubjectResource\Pages;

use App\Filament\Resources\SubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubjects extends ListRecords
{
    protected static string $resource = SubjectResource::class;

    protected function getHeaderActions(): array
    {
        if (auth()->user()->role == 'Admin') {
            return [
                Actions\CreateAction::make()
                    ->label('New Subject')
                    ->icon('heroicon-o-plus'),

                Actions\Action::make('print')
                    ->url(fn () => route('download.allsubjects'))
                    ->openUrlInNewTab()
                    ->label('Print')
                    ->icon('heroicon-o-printer')
                    ->color('danger'),



            ];
        }
        return [];
    }
}
