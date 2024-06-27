<?php

namespace App\Filament\Resources\EnrollmentResource\Pages;

use Filament\Actions;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\EnrollmentResource;

class CreateEnrollment extends CreateRecord
{
    protected static string $resource = EnrollmentResource::class;

}
