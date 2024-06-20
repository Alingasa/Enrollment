<?php

namespace App\Filament\Resources\EnrollmentResource\Pages;

use Filament\Actions;
use App\EnrolledStatus;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EnrollmentResource;

class EditEnrollment extends EditRecord
{
    protected static string $resource = EnrollmentResource::class;


    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        if($section = $record->section) {
            // $subjects = Subject::where('section_id', $section->id)->pluck('id');
            $subjects = $section->subjects()->pluck('id');
            $record->subjects()->syncWithoutDetaching($subjects);
        }
        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

}
