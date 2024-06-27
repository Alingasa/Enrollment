<?php

namespace App\Filament\Teacher\Resources;

use stdClass;
use Filament\Forms;
use App\Models\Room;
use Filament\Tables;
use App\Models\Strand;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Teacher\Resources\SubjectResource\Pages;
use App\Filament\Teacher\Resources\SubjectResource\RelationManagers;
use App\Filament\Resources\SubjectResource\RelationManagers\EnrollmentsRelationManager;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Subjects')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('teacher_id')
                    ->label('Teacher')
                    ->options(Teacher::all()->pluck('full_name', 'id')),
                        // ->relationship(name: 'teachers', titleAttribute: 'first_name'),
                        // ->numeric(),
                    Forms\Components\Select::make('room_id')
                    ->label('Room')
                    ->options(Room::all()->pluck('room', 'id')),
                    Forms\Components\Select::make('section_id')
                    ->label('Strand')
                    ->options(Section::all()->pluck('name', 'id')),
                    Forms\Components\TextInput::make('subject_code')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('subject_title')
                        ->maxLength(255),
                    Forms\Components\Select::make('strand_id')
                        ->label('Strand')
                        ->options(Strand::all()->pluck('name', 'id')),
                    Forms\Components\TextInput::make('subject_type')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('units')
                        ->numeric(),
                    Forms\Components\TextInput::make('grade_level')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('day'),
                    Forms\Components\TextInput::make('time_start')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('time_end')
                        ->maxLength(255),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                ->default('TBA'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->icon(''),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
            EnrollmentsRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'view' => Pages\ViewSubject::route('/{record}'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
        ->whereHas('teacher', function($query){
            $query->where('user_id', auth()->user()->id);
        })
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
