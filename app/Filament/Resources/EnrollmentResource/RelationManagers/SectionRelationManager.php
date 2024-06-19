<?php

namespace App\Filament\Resources\EnrollmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SectionRelationManager extends RelationManager
{
    protected static string $relationship = 'section';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subjects')
                    ->required()
                    ->maxLength(255)
                    ->live(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('No Subject Yet')
            ->recordTitleAttribute('subjects')
            ->columns([
                Tables\Columns\TextColumn::make('subjects.subject_code')
                ->listWithLineBreaks()
                ->bulleted()
                ->label('Subject Code'),
                Tables\Columns\TextColumn::make('subjects.subject_title')
                ->bulleted()
                ->listWithLineBreaks()
                ->label('Subject Title'),
                Tables\Columns\TextColumn::make('subjects.subject_type')
                ->bulleted()
                ->listWithLineBreaks()
                ->label('Subject Type'),
                // Tables\Columns\TextColumn::make('teachers.full_name')
                // ->bulleted()
                // ->listWithLineBreaks()
                // ->label('Teacher'),
            ])
            ->filters([
                //
            ]);
    }
}
