<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Component;

class Schedule extends Component
{
    protected string $view = 'forms.components.schedule';

    public static function make(): static
    {
        return app(static::class);
    }
}
