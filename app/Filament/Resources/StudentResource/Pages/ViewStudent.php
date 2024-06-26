<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\EnrollmentResource;
use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStudent extends ViewRecord
{

    protected static string $resource = EnrollmentResource::class;

    public ?array $data = [];

    protected function getHeaderActions(): array
    {
        // dd($this->data);
        return [
            Actions\EditAction::make()
            ->label('Edit')
            ->color('warning')
            ->icon('heroicon-o-pencil-square'),


            Actions\Action::make('print')
            ->url(fn() => route('download.studentProfile',[
                'record' => $this->data['id'],
            ]))
            ->openUrlInNewTab()
            ->label('print profile')
            ->icon('heroicon-o-printer')
            ->color('danger'),

            Actions\EditAction::make()
            ->label('Edit')
            ->color('warning')
            ->icon('heroicon-o-pencil-square'),
        ];

    }
}
