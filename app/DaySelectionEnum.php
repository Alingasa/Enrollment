<?php

namespace App;


use Filament\Support\Contracts\HasLabel;

enum DaySelectionEnum: string implements HasLabel
{
    case MONDAY = 'Mon';
    case TUESDAY = 'Tue';
    case WEDNESDAY = 'Wed';
    case THURSDAY = 'Thu';
    case FRIDAY = 'Fri';
    case SATURDAY = 'Sat';


    public function getLabel(): ?string
    {
        return match ($this) {

            self::MONDAY =>'Monday',
            self::TUESDAY =>'Tue',
            self::WEDNESDAY =>'Wednesday',
            self::THURSDAY =>'Thursday',
            self::FRIDAY =>'Friday',
            self::SATURDAY => 'Saturday'

        };
    }
}
