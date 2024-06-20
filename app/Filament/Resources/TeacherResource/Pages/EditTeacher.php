<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use Filament\Actions;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\TeacherResource;

class EditTeacher extends EditRecord
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    // protected function mutateFormDataBeforeFill(array $data): array
    // {

    //     // if($section = $record->section) {
    //     //     // $subjects = Subject::where('section_id', $section->id)->pluck('id');
    //     //     $subjects = $section->subjects()->pluck('id');
    //     //     $record->subjects()->syncWithoutDetaching($subjects);
    //     // }

    //     // $teacher = Teacher::find($data['id']);
    //     // $record =  $teacher->subjects()->pluck('id');
    //     // dd($record);
    //     // $teacher->subjects()->syncWithoutDetaching($record);
    //     // if (isset($data['id'])) {
    //     //     $teacher = Teacher::findOrFail($data['id']);
    //     //     $subjectIds = $teacher->subjects()->pluck('id')->toArray();
    //     //     $teacher->subjects()->attach($subjectIds);
    //     // }

    //     return $data;
    // }

}
