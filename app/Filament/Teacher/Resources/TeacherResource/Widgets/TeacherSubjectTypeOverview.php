<?php

namespace App\Filament\Teacher\Resources\TeacherResource\Widgets;

use App\EnrolledStatus;
use App\Models\Enrollment;
use App\Models\Subject;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TeacherSubjectTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            Stat::make('Subjects', Subject::whereHas('teacher', fn($query) => $query->where('user_id', auth()->user()->id))->count())
            ->description('Subjects')
            ->descriptionIcon('heroicon-m-book-open', IconPosition::Before),
            Stat::make('Students', Subject::with('enrollments')->where('id',auth()->user()->id)->count())
            ->description('Students')
            ->descriptionIcon('heroicon-m-book-open', IconPosition::Before),

        ];
    }
}
