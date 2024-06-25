<?php

namespace App\Filament\Teacher\Resources\Teacher\Resources\SubjectResource\Widgets;

use App\EnrolledStatus;
use App\Models\Enrollment;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TeacherSubjectTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make('Enrolled', Enrollment::query()->count())
            ->description('Enrollee')
            ->descriptionIcon('heroicon-m-users', IconPosition::Before),
        ];
    }
}
