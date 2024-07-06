<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeachers extends ListRecords
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        if (auth()->user()->role == 'Teacher') {
            return [];
        }
        return [
            Actions\CreateAction::make()
                ->label('New Teacher')
                ->icon('heroicon-o-plus'),

            Actions\Action::make('Print')
                ->url(fn () => route('download.allteacher'))
                ->openUrlInNewTab()
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->color('danger'),
        ];
    }
}
