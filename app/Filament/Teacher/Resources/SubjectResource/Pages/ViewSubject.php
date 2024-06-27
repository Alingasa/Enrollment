<?php

namespace App\Filament\Teacher\Resources\SubjectResource\Pages;

use App\Filament\Teacher\Resources\SubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSubject extends ViewRecord
{
    protected static string $resource = SubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
            //     ->headerActions([
            //     // Tables\Actions\CreateAction::make(),
            //     // Tables\Actions\AttachAction::make(),
            //     Tables\Actions\Action::make('Print')
            //     ->url(fn () => route('teacher.profile', [
            //         'record' => $this->getOwnerRecord(),
            //     ]))
            //     ->openUrlInNewTab()
            //     ->label('Print')
            //     ->icon('heroicon-m-printer')
            //     ->color('danger'),
            // ])
            // Actions\Action::make('Print')
            // ->url(fn () => route('teacher.profile', [
            //     'record' => $this->data['id'],
            // ]))
            // ->openUrlInNewTab()
            // ->label('Print')
            // ->icon('heroicon-m-printer')
            // ->color('danger'),

            // Actions\EditAction::make()
            // ->color('warning')
            // ->icon('heroicon-o-pencil-square'),
        ];
    }
}
