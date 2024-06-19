<?php

namespace App\Filament\Widgets;

use App\Models\Strand;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Enrollment;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DataTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make('Enrolled', Enrollment::query()->count())
            ->description('Enrollee')
            ->descriptionIcon('heroicon-m-users', IconPosition::Before),
            Stat::make('Subjects', Subject::query()->count())
            ->description('Subjects')
            ->descriptionIcon('heroicon-m-book-open', IconPosition::Before),
            Stat::make('Strands', Strand::query()->count())
            ->description('Strands')
            ->descriptionIcon('heroicon-m-adjustments-vertical', IconPosition::Before),
            Stat::make('Students', Student::query()->count())
            ->description('Students')
            ->descriptionIcon('heroicon-m-users', IconPosition::Before),
            Stat::make('Section', Section::query()->count())
            ->description('Section')
            ->descriptionIcon('heroicon-m-rectangle-stack', IconPosition::Before),
        ];
    }
}
