<?php

namespace App\Filament\Resources;

use stdClass;
use App\GenderEnum;
use Filament\Forms;
use Filament\Tables;
use App\Models\Teacher;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Contracts\View\View;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TeacherResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Filament\Resources\TeacherResource\RelationManagers\SubjectsRelationManager;

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
                    // ->avatar()
                    // ->columnSpanFull()
                    ->previewable()
                    ->imagePreviewHeight(200)
                    ->imageEditor()
                    ->image(),
                    Forms\Components\ViewField::make('qr_code')
                    ->label('Qr Code')
                    ->view('filament.resources.student-resource.pages.view-qr-code', ['record' => 'record']) // Initialize record as null
                    ->afterStateUpdated(function ($state, $set) {
                        // Fetch enrollment data based on state
                        $enrollment = Teacher::find($state->get('id'));
                        if ($enrollment) {
                            $set(['record' => $enrollment->toArray()]); // Passes $record variable to the view as array
                        } else {
                            $set(['record' => null]); // Ensure record is null if no enrollment found
                        }
                    }),

                ]),
                Forms\Components\Section::make('Personal Information')
                ->columns(3)
                ->schema([

                    Forms\Components\TextInput::make('first_name')
                    ->placeholder('juan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('middle_name')
                    ->placeholder('dela')
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->placeholder('cruz')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->placeholder('example@gmail.com')
                    ->unique(table: 'teachers', column: 'email', ignoreRecord: true)
                    ->unique(table: 'users', column: 'email', ignoreRecord: true)
                    ->email()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('birthdate')
                    ->required(),
                Forms\Components\Select::make('gender')
                    ->options(GenderEnum::class)
                    ->required(),
                Forms\Components\TextInput::make('contact_number')
                    ->placeholder('09xxxxxxxxx')
                    ->numeric()
                    ->maxLength(11),
                    Forms\Components\TextInput::make('school_id')
                    ->placeholder('000000')
                    ->unique(table: 'teachers', column: 'school_id', ignoreRecord: true)
                    ->required()
                    ->maxLength(255),

                ]),



                Forms\Components\Section::make('Personal Address')
                ->columns(2)
                ->schema([
                Forms\Components\TextInput::make('barangay')
                    ->placeholder('barangay')
                    ->maxLength(255),
                Forms\Components\TextInput::make('municipality')
                    ->placeholder('municipality')
                    ->maxLength(255),
                Forms\Components\TextInput::make('province')
                    ->placeholder('province')
                    ->maxLength(255),
                Forms\Components\TextInput::make('zip_code')
                    ->placeholder('0000')
                    ->numeric(),

                ]),


                Forms\Components\Section::make('Incase of Emergency')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('guardian_name')
                    ->label('Parents \ Guardian name')
                    ->placeholder('juan dela cruz')
                    ->maxLength(255),
                    Forms\Components\TextInput::make('incaseof_emergency')
                    ->label('Contact Number')
                    ->placeholder('09xxxxxxxxx')
                    ->maxLength(11)
                    ->numeric(),
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
                        ->sortable(['first_name', 'last_name', 'middle_name']),
                    Tables\Columns\TextColumn::make('user.email')
                        ->label('Email')
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
                // Tables\Actions\ViewAction::make(),
            //     Tables\Actions\EditAction::make(),
            //     Tables\Actions\Action::make('Qr')
            //     ->icon('heroicon-o-qr-code')
            //     ->modalCancelActionLabel('Close')
            //    ->modalContent(fn (Teacher $record): View => view(
            //       'filament.resources.student-resource.pages.teacher',
            //    ['record' => $record],
            //    ))->modalSubmitAction(false),
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'view' => Pages\ViewTeacher::route('/{record}'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
            'qr-code' => Pages\ViewQrCode::route('/{record}/qr-code'),
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
