<?php

namespace App\Filament\Resources;

use stdClass;
use Filament\Forms;
use App\Models\Room;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RoomResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Filament\Resources\RoomResource\RelationManagers\SubjectsRelationManager;
use Filament\Support\Enums\Alignment;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-columns';

    protected static ?string $modelLabel = 'Rooms';

    protected static ?string $navigationGroup = 'Settings';

    public static function getNavigationBadgeColor(): string | array | null
    {
        return 'success';
    }

    public static function getNavigationBadge(): ?string
    {

        $count = Room::count();

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
                Forms\Components\Fieldset::make('Rooms')
                    ->schema([
                        Forms\Components\TextInput::make('room')
                            ->label('')
                            ->placeholder('create room')
                            ->unique(table: 'rooms', column: 'room', ignoreRecord: true)
                            ->autocapitalize()
                            ->required()
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
                )
                    ->width(20),
                Tables\Columns\TextColumn::make('room')
                    ->label('Rooms')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subjects_count')
                    ->label('Subjects')
                    ->sortable()
                    ->alignCenter(true)
                    ->counts('subjects')
                    ->searchable(),
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
            ])
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
            SubjectsRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'view' => Pages\ViewRoom::route('/{record}'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
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
