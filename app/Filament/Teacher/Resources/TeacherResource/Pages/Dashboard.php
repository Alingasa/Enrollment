<?php

namespace App\Filament\Teacher\Resources\TeacherResource\Pages;

use App\Filament\Teacher\Resources\TeacherResource;
use Filament\Resources\Pages\Page;

class Dashboard extends Page
{
    protected static string $resource = TeacherResource::class;

    protected static string $view = 'filament.teacher.resources.teacher-resource.pages.dashboard';
}
