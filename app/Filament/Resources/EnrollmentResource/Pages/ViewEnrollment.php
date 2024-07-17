<?php

namespace App\Filament\Resources\EnrollmentResource\Pages;

use Filament\Actions;
use App\EnrolledStatus;
use App\Models\Enrollment;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\EnrollmentResource;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class ViewEnrollment extends ViewRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('approve')
                // ->label('')
                ->color('success')
                ->modalHeading('Approve')
                ->requiresConfirmation()
                ->icon('heroicon-o-hand-thumb-up')
                ->form([
                    Select::make('section_id')
                        ->relationship(
                            name: 'section',
                            titleAttribute: 'name',
                        )
                        ->searchable()
                        ->preload()
                        // ->placeholder(fn ($record) => $record->section()->pluck('name', 'id'))
                        ->label('Section')
                        ->required(),
                ])
                ->action(
                    function (Enrollment $record) {
                        $record->update([
                            'section_id' => $record->section_id,
                            'status'    => EnrolledStatus::ENROLLED,
                        ]);
                        if ($section = $record->section) {
                            $subjects = $section->subjects()->pluck('id');
                            $record->subjects()->syncWithoutDetaching($subjects);
                        }
                        Notification::make()
                            ->title('Student Approved Successfully!')
                            ->icon('heroicon-o-check-circle')
                            ->success()
                            ->send();
                        $record->save();
                        return $record;
                    }
                )->visible(function (Enrollment $record) {
                    return $record->status == EnrolledStatus::PENDING;
                }),
            Actions\Action::make('reject')
                // ->label('')
                ->modalHeading('Reject')
                ->color('danger')
                ->requiresConfirmation()
                ->icon('heroicon-o-hand-thumb-down')
                ->action(function ($record) {
                    Notification::make()
                        ->title('Rejected')
                        ->icon('heroicon-o-x-circle')
                        ->danger()
                        ->send();
                    $record->update([
                        'status' => EnrolledStatus::PENDING,
                    ]);
                })->visible(function ($record) {
                    return $record->status == EnrolledStatus::ENROLLED;
                }),
            Actions\EditAction::make()
                ->label('Edit')
                ->color('warning')
                ->icon('heroicon-o-pencil-square'),

        ];
    }

    public function getHeading(): string | Htmlable
    {
        // dd($this->getRecord()->full_name);
        return $this->getRecord()->full_name;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'School ID: ' . ($this->getRecord()->school_id ?: 'Not Set');
    }


}
