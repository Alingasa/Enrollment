<?php

namespace App\Filament\Resources;

use stdClass;
use App\GradeEnum;
use Filament\Forms;
use Filament\Tables;
use App\Models\Subject;
use Filament\Forms\Form;
use App\DaySelectionEnum;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\SubjectResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubjectResource\RelationManagers;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('teacher_id')
                    ->label('Teacher')
                    ->relationship(name: 'teacher', titleAttribute: 'first_name')
                    ->required()
                    ->live()
                    ->preload()
                    ->searchable(['first_name', 'last_name', 'middle_name']),
                Forms\Components\Select::make('section_id')
                ->label('Section')
                ->relationship(name: 'section', titleAttribute: 'name' )
                ->required()
                ->live()
                ->preload()
                ->searchable(),
                Forms\Components\TextInput::make('subject_code')
                    ->required(),
                Forms\Components\TextInput::make('subject_title')
                    ->required(),
                Forms\Components\Select::make('subject_type')
                    ->options([
                        'LECTURE' => 'LECTURE',
                        'LABORATORY' => 'LABORATORY'
                    ])
                    ->required(),
                Forms\Components\TextInput::make('units')
                    ->maxLength(1)
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('grade_level')
                    ->live()
                    ->options(GradeEnum::class)
                    ->required(),
                Forms\Components\Select::make('room_id')
                    ->live()
                    ->preload()
                    ->searchable()
                    ->required()
                    ->relationship(name: 'room', titleAttribute: 'room')
                    ->label('Room ID')
                    ->unique(table: 'subjects', column: 'room_id', ignoreRecord: true),


                Forms\Components\Select::make('strand_id')
                    ->relationship(name: 'strand', titleAttribute: 'name')
                    ->visible(fn ($get, $operation) => ($operation == 'edit' || $operation == 'create') && in_array($get('grade_level'), [
                        GradeEnum::GRADE11->value,
                        GradeEnum::GRADE12->value,

                    ])),

                    ]),
                    Forms\Components\Section::make('Schedule')
                    ->schema([
                        Forms\Components\CheckboxList::make('day')
                       ->label('Day')

                       ->options(DaySelectionEnum::class)
                       ->columns(6),
                        Forms\Components\TimePicker::make('time_start')
                        ->seconds(false),
                        Forms\Components\TimePicker::make('time_end')
                        ->seconds(false),
                    ]),
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
                Tables\Columns\TextColumn::make('teacher.full_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('section.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('strand.name')
                    ->default('No Strand')
                    ->badge()
                    ->color(fn ($state) => match($state){
                        'No Strand' => 'danger',
                        $state => 'warning',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('units')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grade_level')
                    ->searchable(),
                Tables\Columns\TextColumn::make('room')
                    ->default('TBA')
                    ->color(fn ($state) => match($state){
                        'TBA' => 'danger',
                        $state => '',
                       })
                    ->searchable(),
                Tables\Columns\TextColumn::make('day')
                ->label('Schedule')
                ->formatStateUsing(function ($state, $record) {
                    $string = '';
                   $string = $state .'/'.' '.'('.$record->time_start.'-'.$record->time_end.')';
                //    dd($record);
                   return $string;
                  }),
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
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('grade_level')
                ->options(GradeEnum::class),
                SelectFilter::make('strand_id')
                ->label('By Strands')
                ->relationship('strand', 'name'),
                SelectFilter::make('section_id')
                ->label('By Section')
                ->relationship('section', 'name'),
            ],  layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
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
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
