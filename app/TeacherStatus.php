<?php

namespace App;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TeacherStatus: string implements HasLabel, HasIcon, HasColor
{
    case PENDING = '1';
    case ENROLLED = '2';
    // case SETID = 'Set ID';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ENROLLED => 'Enrolled',
            // self::SETID => 'Set ID',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::PENDING    => 'warning',
            self::ENROLLED    => 'success',
            // self::SETID    => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ENROLLED    => 'heroicon-o-check-circle',
            self::PENDING      => 'heroicon-o-arrow-path',
            // self::SETID    => 'heroicon-o-check-circle',
        };
    }
}
