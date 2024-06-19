<?php

namespace App\Filament\Resources\StrandResource\Pages;

use App\Filament\Resources\StrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStrand extends ViewRecord
{
    protected static string $resource = StrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
