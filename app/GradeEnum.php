<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum GradeEnum: string implements HasLabel
{
    case GRADE7 = '7';
    case GRADE8 = '8';
    case GRADE9 = '9';
    case GRADE10 = '10';
    case GRADE11 = '11';
    case GRADE12 = '12';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::GRADE7 => 'Grade 7',
            self::GRADE8 => 'Grade 8',
            self::GRADE9 => 'Grade 9',
            self::GRADE10 => 'Grade 10',
            self::GRADE11 => 'Grade 11',
            self::GRADE12 => 'Grade 12',
        };
    }
}
