<?php

namespace App\Filament\Resources\TeacherResource\RelationManagers;

use stdClass;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SubjectResource;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SubjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'subjects';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('subject_title')
                //     ->required()
                //     ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table

            ->recordTitleAttribute('subject_title')
            ->recordUrl(fn ($record) => SubjectResource::getUrl('view', ['record' => $record]))
            ->columns([
                Tables\Columns\TextColumn::make('#')->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                Tables\Columns\TextColumn::make('subject_code')
                ->label('Code')
                ->searchable(),
                Tables\Columns\TextColumn::make('subject_title')
                ->label('Subject')
                ->searchable(),
                Tables\Columns\TextColumn::make('section.name')
                ->numeric()
                ->sortable(),
                Tables\Columns\TextColumn::make('teacher.full_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('day')
                    ->label('Schedule')
                    ->formatStateUsing(function ($state, $record) {
                        $string = '';
                       $string = $state .'/'.' '.'('.$record->time_start.'-'.$record->time_end.')';
                    //    dd($record);
                       return $string;
                      }),
                Tables\Columns\TextColumn::make('subject_type')
                      ->searchable(),
                  Tables\Columns\TextColumn::make('units')
                      ->numeric()
                      ->sortable(),
                Tables\Columns\TextColumn::make('room.room')
                      ->label('Room')
                      ->default('TBA')
                      ->searchable(),
            ])
            ->filters([

                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                // Tables\Actions\AttachAction::make(),
                Tables\Actions\Action::make('Print')
                ->url(fn () => route('teacher.profile', [
                    'record' => $this->getOwnerRecord(),
                ]))
                ->openUrlInNewTab()
                ->label('Print')
                ->icon('heroicon-m-printer')
                ->color('danger'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DetachAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('view')
                ->label('')
                ->icon(''),
            ]);
    }
}
