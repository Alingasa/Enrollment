<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Resources\StudentResource;
use App\Filament\Resources\EnrollmentResource;

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
                ->url(fn () => route('download.studentProfile', [
                    'record' => $this->data['id'],
                ]))
                ->openUrlInNewTab()
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->color('danger'),


        ];
    }

    public function getHeading(): string | Htmlable
    {
        // dd($this->getRecord()->full_name);
        return $this->getRecord()->full_name;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'School ID: ' . ($this->getRecord()->school_id ?: 'Not Set');
    }
}
