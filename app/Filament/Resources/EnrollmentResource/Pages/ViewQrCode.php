<?php

namespace App\Filament\Resources\EnrollmentResource\Pages;

use App\Filament\Resources\EnrollmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewQrCode extends ViewRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected static string $view = 'filament.resources.student-resource.pages.view-qr-code';
}
