<?php

namespace App\Filament\Widgets;

use App\EnrolledStatus;
use App\Models\Strand;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\Room;
use App\Models\Teacher;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DataTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        if (auth()->user()->role == 'Admin') {
            return [
                //
                Stat::make('Enrollee', Enrollment::query()->where('status', EnrolledStatus::PENDING)->count())
                    ->description('Enrollee')
                    ->descriptionIcon('heroicon-m-users', IconPosition::Before),
                Stat::make('Students', Enrollment::query()->where('status', EnrolledStatus::ENROLLED)->count())
                    ->description('Students')
                    ->descriptionIcon('heroicon-m-users', IconPosition::Before),
                Stat::make('Teachers', Teacher::query()->count())
                    ->description('Teachers')
                    ->descriptionIcon('heroicon-m-users', IconPosition::Before),
                Stat::make('Subjects', Subject::query()->count())
                    ->description('Subjects')
                    ->descriptionIcon('heroicon-m-book-open', IconPosition::Before),
                Stat::make('Section', Section::query()->count())
                    ->description('Section')
                    ->descriptionIcon('heroicon-m-rectangle-stack', IconPosition::Before),
                Stat::make('Strands', Strand::query()->count())
                    ->description('Strands')
                    ->descriptionIcon('heroicon-m-adjustments-vertical', IconPosition::Before),
                Stat::make('Rooms', Room::query()->count())
                    ->description('Rooms')
                    ->descriptionIcon('heroicon-m-adjustments-vertical', IconPosition::Before),
            ];
        }
        return [
            Stat::make('Subjects', Subject::whereHas('teacher', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })->count())
                ->description('Subjects')
                ->descriptionIcon('heroicon-m-book-open', IconPosition::Before),
            Stat::make('Section', Section::query()->count())
                ->description('Section')
                ->descriptionIcon('heroicon-m-rectangle-stack', IconPosition::Before),
            Stat::make('Strands', Strand::query()->count())
                ->description('Strands')
                ->descriptionIcon('heroicon-m-adjustments-vertical', IconPosition::Before),
            Stat::make('Rooms', Room::query()->count())
                ->description('Rooms')
                ->descriptionIcon('heroicon-m-adjustments-vertical', IconPosition::Before),
        ];
    }
}
