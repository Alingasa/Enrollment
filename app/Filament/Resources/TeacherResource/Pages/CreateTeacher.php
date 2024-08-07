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



    protected function handleRecordCreation(array $data): Model
    {

        $email = strtolower($data['first_name'][0]).".".strtolower($data['last_name'])."@hsenrollment.com";
        // $record = new ($this->getModel())(Arr::except($data, ['email']));
        $i = 1;
        while (User::where('email', $email)->exists()) {
            $email = strtolower($data['first_name'][0]).".".strtolower($data['last_name']) . $i ."@hsenrollment.com";
            $i++;
        }

        $record = new ($this->getModel())(Arr::except($data, ['qr_code']));

        $record['user_id'] = $record->user()->create([
            'name'      => $record->full_name,
            'email'     => $email,
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

