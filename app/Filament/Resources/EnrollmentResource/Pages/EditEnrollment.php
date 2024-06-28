<?php

namespace App\Filament\Resources\EnrollmentResource\Pages;

use Filament\Actions;
use App\EnrolledStatus;
use App\Models\Subject;
use Illuminate\Support\Arr;
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
        if($data['grade_level'] <= 10){
            $data['strand_id'] = null;
        }
        $record->update(Arr::except($data, ['qr_code']));

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
            // Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

}
