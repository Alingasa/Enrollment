<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum CivilStatusEnum: string implements HasLabel
{
    case SINGLE = '1';
    case MARRIED = '2';
    case LIVING_TOGETHER = '3';
    case SEPARATED = '4';
    case DIVORCED = '5';
    case WIDOWED = '6';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SINGLE => 'Single',
            self::MARRIED => 'Married',
            self::LIVING_TOGETHER => 'Living Together',
            self::SEPARATED => 'Separated',
            self::DIVORCED => 'Divorced',
            self::WIDOWED => 'Widowed',
        };
    }
}
