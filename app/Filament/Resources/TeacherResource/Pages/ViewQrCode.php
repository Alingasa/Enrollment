<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewQrCode extends ViewRecord
{
    protected static string $resource = TeacherResource::class;

    protected static string $view = 'filament.resources.student-resource.pages.view-qr-code';

}
