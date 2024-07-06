<?php

namespace App\Filament\Resources\SubjectResource\Pages;

use Filament\Actions;
use App\Models\Teacher;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Resources\SubjectResource;

class EditSubject extends EditRecord
{
    protected static string $resource = SubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    public function getHeading(): string | Htmlable
    {
        // dd($this->getRecord());
        return Teacher::findorFail($this->getRecord()->teacher_id)->full_name;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'School ID: ' . (Teacher::findorFail($this->getRecord()->teacher_id)->school_id ?: 'Not Set');
    }
}
