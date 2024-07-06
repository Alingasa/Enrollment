<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewTeacher extends ViewRecord
{
    protected static string $resource = TeacherResource::class;

    public ?array $data = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Print')
                ->url(fn () => route('teacher.profile', [
                    'record' => $this->data['id'],
                ]))
                ->openUrlInNewTab()
                ->label('Print')
                ->icon('heroicon-m-printer')
                ->color('danger'),

            Actions\EditAction::make()
                ->color('warning')
                ->icon('heroicon-o-pencil-square'),


        ];
    }

    public function getHeading(): string | Htmlable
    {
        return $this->getRecord()->full_name;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'School ID: ' . ($this->getRecord()->school_id ?: 'Not Set');
    }
}
