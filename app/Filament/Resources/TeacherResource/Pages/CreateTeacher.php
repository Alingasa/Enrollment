<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Models\Teacher;
use Illuminate\Support\Arr;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TeacherResource;

class CreateTeacher extends CreateRecord
{
    protected static string $resource = TeacherResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {

    //     // dd($sample);
    //     // dd($data['email']);
    //     // $teacher = Teacher::find($data);

    //     $data['user_id'] = User::create([
    //         // 'user_id' => $userId,
    //         // 'role' => 'teacher',
    //         'name' => $data['first_name'].' '.$data['middle_name'][0].'.'.' '.$data['last_name'],
    //         'email' => $data['email'],
    //         'password' => 'password',
    //     ])->id;

    //     return $data;
    // }

    protected function handleRecordCreation(array $data): Model
    {
        $record = new ($this->getModel())($data);

       $record['user_id'] = $record->user()->create([
            'name'      => $record->full_name,
            'email'     => $data['email'],
            'password'  => 'password'
        ])->id;

        if (
            static::getResource()::isScopedToTenant() &&
            ($tenant = Filament::getTenant())
        ) {
            return $this->associateRecordWithTenant($record, $tenant);
        }

        $record->save();

        return $record;
    }
}
