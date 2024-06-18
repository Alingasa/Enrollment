<?php

namespace App;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum GenderEnum: string implements HasLabel, HasColor
{
    case MALE = 'Male';
    case FEMALE = 'Female';


    public function getLabel(): ?string
    {
        return match ($this) {
            self::MALE    => 'Male',
            self::FEMALE    => 'Female',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::MALE    => 'primary',
            self::FEMALE    => 'warning',
        };
    }
}
