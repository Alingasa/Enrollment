<?php

namespace App\Filament\Resources\EnrollmentResource\Pages;

use Filament\Actions;
use Illuminate\Support\Arr;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\EnrollmentResource;

class CreateEnrollment extends CreateRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $record = new ($this->getModel())(Arr::except($data, ['qr_code']));

        if (
            static::getResource()::isScopedToTenant() &&
            ($tenant = Filament::getTenant())
        ) {
            return $this->associateRecordWithTenant($record, $tenant);
        }

        $record->save();

        return $record;
    }

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {

    //      $defaultImagePath = asset('default_images/me.jpg');

    //     // Check if 'profile_image' is null or not set in $data
    //     if (!isset($data['profile_image']) || is_null($data['profile_image'])) {
    //         $data['profile_image'] = $defaultImagePath;
    //     }
    //     return $data;
    // }

}
