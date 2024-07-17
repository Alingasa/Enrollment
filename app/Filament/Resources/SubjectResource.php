<?php

namespace App\Filament\Resources;

use stdClass;
use App\GradeEnum;
use Filament\Forms;
use Filament\Tables;
use App\Models\Subject;
use App\Models\Teacher;
use Filament\Forms\Form;
use App\DaySelectionEnum;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\SubjectResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubjectResource\RelationManagers;
use App\Filament\Resources\SubjectResource\RelationManagers\EnrollmentsRelationManager;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Settings';


    public static function getNavigationBadgeColor(): string | array | null
    {
        return 'success';
    }

    public static function getNavigationBadge(): ?string
    {

        if (auth()->user()->role == 'Admin') {
            $count = Subject::count();

            if ($count == 0) {
                return null;
            }
            return $count;
        }

        $count = Subject::whereHas('teacher', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->count();

        if ($count == 0) {
            return null;
        }
        return $count;
    }

    public static function canCreate(): bool
    {
        return static::can('create') && auth()->user()->role == 'Admin';
    }

    public static function canEdit(Model $record): bool
    {
        return static::can('update', $record) && auth()->user()->role == 'Admin';
    }

    public static function canDelete(Model $record): bool
    {
        return static::can('delete', $record) && auth()->user()->role == 'Admin';
    }

    public static function canDeleteAny(): bool
    {
        return static::can('deleteAny') && auth()->user()->role == 'Admin';
    }

    public static function canForceDelete(Model $record): bool
    {
        return static::can('forceDelete', $record) && auth()->user()->role == 'Admin';
    }

    public static function canForceDeleteAny(): bool
    {
        return static::can('forceDeleteAny') && auth()->user()->role == 'Admin';
    }

    public static function canReorder(): bool
    {
        return static::can('reorder') && auth()->user()->role == 'Admin';
    }

    public static function canReplicate(Model $record): bool
    {
        return static::can('replicate', $record) && auth()->user()->role == 'Admin';
    }

    public static function canRestore(Model $record): bool
    {
        return static::can('restore', $record) && auth()->user()->role == 'Admin';
    }

    public static function canRestoreAny(): bool
    {
        return static::can('restoreAny') && auth()->user()->role == 'Admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('teacher_id')
                            ->label('Teacher')
                            ->options(Teacher::all()->pluck('full_name', 'id'))
                            ->hiddenOn('view')
                            // ->relationship(name: 'teachers', titleAttribute: 'first_name')
                            // ->getOptionLabelFromRecordUsing(fn (Teacher $record) => dd($record))
                            ->required()
                            ->live()
                            ->preload()
                            ->searchable(['first_name', 'last_name', 'middle_name']),
                        Forms\Components\Select::make('section_id')
                            ->label('Section')
                            ->relationship(name: 'section', titleAttribute: 'name')
                            ->required()
                            ->live()
                            ->preload()
                            ->searchable(),
                        Forms\Components\TextInput::make('subject_code')
                            ->label('Subject Code')
                            ->placeholder('subject Code')
                            ->unique(table: "subjects", column: "subject_code", ignoreRecord: true)
                            ->required(),


                        Forms\Components\TextInput::make('subject_title')
                            ->label('Description')
                            ->placeholder('Description')
                            ->required(),
                        Forms\Components\Select::make('subject_type')
                            ->label('Subject Type')
                            ->options([
                                'LECTURE' => 'LECTURE',
                                'LABORATORY' => 'LABORATORY'
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('units')
                            ->placeholder('0')
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
                            ->label('Room ID'),
                        // ->unique(table: 'subjects', column: 'room_id'),
                        Forms\Components\Select::make('strand_id')
                            ->relationship(name: 'strand', titleAttribute: 'name')
                            ->visible(fn ($get, $operation) => ($operation == 'edit' || $operation == 'create') && in_array($get('grade_level'), [
                                GradeEnum::GRADE11->value,
                                GradeEnum::GRADE12->value,

                            ])),

                    ]),
                Forms\Components\Fieldset::make('Schedule')
                    ->columns(1)
                    ->schema([
                        Forms\Components\CheckboxList::make('day')
                            ->label('Day')
                            ->required()
                            ->options(DaySelectionEnum::class)
                            ->columns(6),
                        Forms\Components\Fieldset::make('Time')
                            ->columns(2)
                            ->schema([
                                Forms\Components\TimePicker::make('time_start')
                                    ->required()
                                    ->seconds(false),
                                Forms\Components\TimePicker::make('time_end')
                                    ->required()
                                    ->seconds(false),
                            ])

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        if (auth()->user()->role == 'Admin') {
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
                        ->label('Description')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('section.name')
                        ->numeric()
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('teacher.full_name')
                        ->numeric()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('day')
                        ->label('Schedule')
                        ->searchable()
                        ->formatStateUsing(function ($state, $record) {
                            $string = '';
                            $string = $state . '/' . ' ' . '(' . $record->time_start . '-' . $record->time_end . ')';
                            //    dd($record);
                            return $string;
                        }),
                    Tables\Columns\TextColumn::make('subject_type')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('units')
                        ->numeric()
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('room.room')
                        ->label('Room')
                        ->searchable()
                        ->default('TBA'),
                    // Tables\Columns\TextColumn::make('strand.name')
                    //     ->default('No Strand')
                    //     ->badge()
                    //     ->color(fn ($state) => match($state){
                    //         'No Strand' => 'danger',
                    //         $state => 'warning',
                    //     })
                    //     ->sortable(),

                    // Tables\Columns\TextColumn::make('grade_level')
                    //     ->searchable(),
                    // Tables\Columns\TextColumn::make('room')
                    //     ->default('TBA')
                    //     ->searchable()
                    //     ->color(fn ($state) => match($state){
                    //         'TBA' => 'danger',
                    //         $state => '',
                    //        })
                    //     ->searchable(),
                    Tables\Columns\TextColumn::make('enrollments_count')
                        ->counts('enrollments')
                        ->alignCenter()
                        ->label('No. of Students')
                        ->toggleable(isToggledHiddenByDefault: true),
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
                ])->defaultSort('created_at', 'desc')
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
                ])
                ->headerActions([])
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
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('#')->state(
                //     static function (HasTable $livewire, stdClass $rowLoop): string {
                //         return (string) (
                //             $rowLoop->iteration +
                //             ($livewire->getTableRecordsPerPage() * (
                //                 $livewire->getTablePage() - 1
                //             ))
                //         );
                //     }
                // ),
                Tables\Columns\TextColumn::make('enrollments_count')
                    ->counts('enrollments')
                    ->alignCenter()
                    ->label('No. of Students'),
                Tables\Columns\TextColumn::make('subject_code')
                    ->label('Code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject_title')
                    ->label('Description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('section.name')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('day')
                    ->label('Schedule')
                    ->searchable()
                    ->formatStateUsing(function ($state, $record) {
                        $string = '';
                        $string = $state . '/' . ' ' . '(' . $record->time_start . '-' . $record->time_end . ')';
                        //    dd($record);
                        return $string;
                    }),
                Tables\Columns\TextColumn::make('subject_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('units')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('room.room')
                    ->label('Room')
                    ->searchable()
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
            ])->defaultSort('created_at', 'desc')
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
            ])
            ->headerActions([])
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
        if (auth()->user()->role == 'Teacher') {
            return parent::getEloquentQuery()
                ->whereHas('teacher', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
        }
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
