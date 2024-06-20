<?php

namespace App\Filament\Resources;

use App\GenderEnum;
use Filament\Forms;
use Filament\Tables;
use App\Models\Teacher;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TeacherResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TeacherResource\RelationManagers;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Settings';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->columns(2)
                ->schema([
                    Forms\Components\FileUpload::make('profile_image')
                    ->avatar()
                    ->previewable()
                    ->imagePreviewHeight(500)
                    ->imageEditor()
                    ->image(),
                    Forms\Components\TextInput::make('school_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('middle_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->unique(table: 'teachers', column: 'email', ignoreRecord: true)
                    ->email()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('birthdate')
                    ->required(),
                Forms\Components\Select::make('gender')
                    ->options(GenderEnum::class)
                    ->required(),
                Forms\Components\TextInput::make('contact_number')
                    ->numeric()
                    ->maxLength(11),
                Forms\Components\TextInput::make('barangay')
                    ->maxLength(255),
                Forms\Components\TextInput::make('municipality')
                    ->maxLength(255),
                Forms\Components\TextInput::make('province')
                    ->maxLength(255),
                Forms\Components\TextInput::make('zip_code')
                    ->numeric(),
                Forms\Components\TextInput::make('guardian_name')
                    ->maxLength(255),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                    Tables\Columns\TextColumn::make('full_name')
                        ->searchable(['first_name', 'middle_name', 'last_name'])
                        ->sortable(),
                    Tables\Columns\TextColumn::make('email')
                        ->copyable()
                       ->copyMessage('Email address copied')
                        ->sortable(),
                    Tables\Columns\TextColumn::make('gender')
                        ->sortable(),
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
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Qr')
                ->icon('heroicon-o-qr-code')
                ->modalCancelActionLabel('Close')
               ->modalContent(fn (Teacher $record): View => view(
                  'filament.resources.student-resource.pages.view-qr-code-teacher',
               ['record' => $record],
               ))->modalSubmitAction(false),
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'view' => Pages\ViewTeacher::route('/{record}'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
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
