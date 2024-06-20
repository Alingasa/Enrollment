<?php

namespace App\Filament\Resources\TeacherResource\RelationManagers;

use stdClass;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SubjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'subjects';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subject_title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('subject_title')
            ->columns([
                Tables\Columns\TextColumn::make('No.')->state(
                    static function (HasTable $livewire, stdClass $rowLoop): string {
                        return (string) (
                            $rowLoop->iteration +
                            ($livewire->getTableRecordsPerPage() * (
                                $livewire->getTablePage() - 1
                            ))
                        );
                    }
                ),
                Tables\Columns\TextColumn::make('section.name'),
                Tables\Columns\TextColumn::make('subject_code'),
                Tables\Columns\TextColumn::make('subject_title'),
                Tables\Columns\TextColumn::make('subject_type'),
                Tables\Columns\TextColumn::make('units'),
                Tables\Columns\TextColumn::make('grade_level'),
                Tables\Columns\TextColumn::make('strand.name')
                ->default('No Strand')
                ->color(fn ($state) => match($state){
                    'No Strand' => 'danger',
                    $state => 'warning',
                })
                ->badge(),
               Tables\Columns\TextColumn::make('room')
               ->default('TBA')
               ->color(fn ($state) => match($state){
                'TBA' => 'danger',
                $state => '',
               }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                // Tables\Actions\AttachAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DetachAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ]);
    }
}
