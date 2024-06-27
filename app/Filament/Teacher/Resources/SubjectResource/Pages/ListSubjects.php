<?php

namespace App\Filament\Teacher\Resources\SubjectResource\Pages;

use App\Filament\Teacher\Resources\SubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubjects extends ListRecords
{
    protected static string $resource = SubjectResource::class;

    public ?array $data = [];

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Actions\Action::make('Print')
            ->url(fn () => route('teacher.profile', [
                'record' => $this->data['id'],
            ]))
            ->openUrlInNewTab()
            ->label('Print')
            ->icon('heroicon-m-printer')
            ->color('danger'),
        ];
    }
}
