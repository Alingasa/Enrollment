<?php

namespace App\Filament\Resources\SubjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments';

    protected static ?string $title = 'Students';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->columns([
                Tables\Columns\ImageColumn::make('profile_image')
                ->circular()
                ->default(url('default_images/me.jpg'))
                ->alignCenter()
                ->sortable(),
            Tables\Columns\TextColumn::make('school_id')
                ->label('School ID')
                ->default('Set ID')
                ->badge()
                ->color('danger')
                ->sortable(),
            Tables\Columns\TextColumn::make('strand.name')
                ->default('No Strand')
                ->badge()
                ->color(fn ($state) => match($state){
                    'No Strand' => 'primary',
                    $state => 'success'
                })
                ->sortable(),
            Tables\Columns\TextColumn::make('full_name')
                ->searchable(['first_name', 'middle_name', 'last_name'])
                ->sortable(),
            Tables\Columns\TextColumn::make('grade_level')
                ->sortable(),
            Tables\Columns\TextColumn::make('email')
                ->copyable()
               ->copyMessage('Email address copied')
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
