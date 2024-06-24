<?php

namespace App\Filament\Resources\SubjectResource\RelationManagers;

use stdClass;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

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
                Tables\Actions\Action::make('Print')
                ->url(fn () => route('download.tes'))
                ->openUrlInNewTab()
                ->label('Print')
                ->icon('heroicon-m-printer')
                ->color('danger')

                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
