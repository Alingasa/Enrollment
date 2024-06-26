<?php

namespace App\Filament\Teacher\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource as ResourcesTeacherResource;
use App\Filament\Teacher\Resources\TeacherResource;
use Filament\Resources\Pages\Page;

class Dashboard extends Page
{
    protected static string $resource = ResourcesTeacherResource::class;

    protected static string $view = 'filament.teacher.resources.teacher-resource.pages.dashboard';
}
