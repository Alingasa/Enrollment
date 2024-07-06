<?php

namespace App\Filament\Teacher\Resources\SubjectResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Teacher\Resources\SubjectResource;

class ViewSubject extends ViewRecord
{
    protected static string $resource = SubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
    public function getHeading(): string | Htmlable
    {
        dd($this->getRecord()->full_name);
        return $this->getRecord()->full_name;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'School ID: ' . ($this->getRecord()->school_id ?: 'Not Set');
    }
}
