<?php

namespace App\Filament\Resources;

use App\GradeEnum;
use App\GenderEnum;
use Filament\Forms;
use Filament\Tables;
use App\ReligionEnum;
use App\EnrolledStatus;
use App\CivilStatusEnum;
use Filament\Forms\Form;
use App\Models\Enrollment;
use Filament\Tables\Table;
use PhpParser\Node\Stmt\Label;
use Doctrine\DBAL\Schema\Column;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Enums\ActionsPosition;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EnrollmentResource\Pages;
use App\Filament\Resources\EnrollmentResource\RelationManagers\SectionRelationManager;
use App\Filament\Resources\EnrollmentResource\RelationManagers\SubjectsRelationManager;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    public static function getNavigationBadgeColor(): string | array | null
    {
        return 'danger';
    }

    public static function getNavigationBadge(): ?string
    {

        $count = Enrollment::where('status', EnrolledStatus::PENDING)->count();

        if ($count == 0) {
            return null;
        }
        return $count;
    }

    public static function canAccess(): bool
    {
        return static::canViewAny() && auth()->user()->role == 'Admin';
    }

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Forms\Components\Fieldset::make('Profile Image')
                    ->columns(2)
                    ->schema([
                        // ViewField::make('qr_code')
                        // ->view('default')
                        // ->hiddenOn(['edit', 'create']),
                        Forms\Components\ViewField::make('qr_code')
                            ->view('default')
                            ->visible(fn ($get, $operation) => empty($get('profile_image')) && ($operation == 'view')),
                        // Forms\Components\FileUpload::make('profile_image')
                        //         // ->avatar()
                        //         ->previewable()
                        //         // ->imageEditorEmptyFillColor(asset('default_images/me.jpg'))
                        //         ->imagePreviewHeight(200)
                        //         ->imageEditor()
                        //         ->downloadable()
                        //         ->image()
                        //         ->hiddenOn('view'),
                        Forms\Components\FileUpload::make('profile_image')
                            ->label('')
                            ->previewable()
                            ->imagePreviewHeight(200)
                            ->imageEditor()
                            ->downloadable()
                            ->image()
                            ->visible(fn ($get, $operation) => in_array($operation, ['create', 'edit']) || (!empty($get('profile_image')) && $operation == 'view')),
                        Forms\Components\ViewField::make('qr_code')
                            ->label('Qr Code')
                            ->view('filament.resources.student-resource.pages.view-qr-code')
                            ->afterStateUpdated(function ($state, $set) {
                                // Fetch enrollment data based on state
                                $enrollment = Enrollment::find($state->get('id'));
                                if ($enrollment) {
                                    $set(['record' => $enrollment->toArray()]); // Passes $record variable to the view as array
                                } else {
                                    $set(['record' => null]); // Ensure record is null if no enrollment found
                                }
                            }),
                    ]),
                Forms\Components\Fieldset::make('Select Grade to Enroll')
                    ->schema([
                        Forms\Components\Fieldset::make()
                            ->schema([

                                Forms\Components\Select::make('grade_level')
                                    ->live()
                                    ->options(GradeEnum::class)
                                    ->required(),

                                Forms\Components\Select::make('strand_id')
                                    ->label('Strand')
                                    ->relationship(name: 'strand', titleAttribute: 'name')
                                    ->preload()
                                    ->visible(function ($get, $operation) {
                                        return ($operation == 'edit' || $operation == 'create') && in_array($get('grade_level'), [
                                            GradeEnum::GRADE11->value,
                                            GradeEnum::GRADE12->value,
                                        ]);
                                    })
                                    ->searchable(),
                            ]),


                        Forms\Components\Select::make('section_id')
                            ->relationship(name: 'section', titleAttribute: 'name')
                            ->searchable()
                            ->preload()
                            ->label('Section')
                            ->visible(function ($get, $operation) {
                                return ($operation == 'edit') && in_array($get('status'), [
                                    EnrolledStatus::ENROLLED->value,
                                ]);
                            }),

                        Forms\Components\TextInput::make('school_id')
                            ->placeholder('Set ID')
                            ->label('School ID')
                            ->visible(function ($get, $operation) {
                                return ($operation == 'edit') && in_array($get('status'), [
                                    EnrolledStatus::ENROLLED->value,
                                ]);
                            })
                            ->unique(table: 'enrollments', column: 'school_id', ignoreRecord: true),
                    ]),

                Forms\Components\Fieldset::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->placeholder('juan')
                            ->required(),

                        Forms\Components\TextInput::make('middle_name')
                            ->placeholder('dela'),

                        Forms\Components\TextInput::make('last_name')
                            ->placeholder('cruz')
                            ->required(),
                        Forms\Components\Select::make('civil_status')
                            ->required()
                            ->options(CivilStatusEnum::class),
                        Forms\Components\Select::make('gender')
                            ->options(GenderEnum::class)
                            ->required(),
                        Forms\Components\Select::make('religion')
                            ->required()
                            ->options(ReligionEnum::class),
                        Forms\Components\DatePicker::make('birthdate')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->unique(table: 'enrollments', column: 'email', ignoreRecord: true)
                            ->placeholder('example@gmail.com')
                            ->live()
                            ->email(),
                        Forms\Components\TextInput::make('contact_number')
                            ->placeholder('09XXXXXXXXX')
                            ->numeric(),
                        Forms\Components\TextInput::make('facebook_url')
                            ->placeholder('https://www.facebook.com/sample-url')
                            ->columnSpanFull(),
                    ])
                    ->columns(3),



                Forms\Components\Fieldset::make('Personal Address')
                    ->schema([
                        Forms\Components\TextInput::make('purok')
                            ->placeholder('purok'),

                        Forms\Components\TextInput::make('sitio_street')
                            ->placeholder('sitio'),

                        Forms\Components\TextInput::make('barangay')
                            ->placeholder('barangay'),

                        Forms\Components\TextInput::make('municipality')
                            ->placeholder('municipality'),

                        Forms\Components\TextInput::make('province')
                            ->placeholder('province'),

                        Forms\Components\TextInput::make('zip_code')
                            ->placeholder('0000')
                            ->numeric(),

                        Forms\Components\TextInput::make('status_type')
                            ->hidden()
                            ->required()
                            ->numeric()
                            ->default(1),
                    ])
                    ->columns(2),


                Forms\Components\Fieldset::make('In case of Emergency')
                    ->schema([
                        Forms\Components\TextInput::make('guardian_name')
                            ->label('Parent / Guardian name')
                            ->placeholder('juan dela cruz')
                            ->required(),
                        Forms\Components\TextInput::make('incaseof_emergency')
                            ->label('Contact Number')
                            ->placeholder('09XXXXXXXXX')
                            ->numeric(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->query(Enrollment::where('status', EnrolledStatus::PENDING))
            ->columns([
                Tables\Columns\TextColumn::make('status')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('profile_image')
                    ->defaultImageUrl(url('default_images/me.jpg'))
                    ->alignCenter()
                    ->circular(),
                Tables\Columns\TextColumn::make('school_id')
                    ->default('Set ID')
                    ->label('School ID')
                    ->badge()
                    ->color(fn ($state): string => match ($state) {
                        'Set ID' => 'danger',
                        $state => 'warning'
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(['first_name', 'middle_name', 'last_name'])
                    ->sortable(['middle_name', 'first_name', 'last_name']),
                Tables\Columns\TextColumn::make('section.name')
                    ->default('Empty')
                    ->badge()
                    ->color(fn ($state): string => match ($state) {
                        'Empty' => 'danger',
                        $state => 'primary'
                    })

                    ->sortable(),
                Tables\Columns\TextColumn::make('strand.name')
                    ->default('No Strand')
                    ->color(fn ($state) => match ($state) {
                        'No Strand' => 'danger',
                        $state => 'warning'
                    })
                    ->badge()
                    ->sortable(),


                Tables\Columns\TextColumn::make('grade_level')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->copyable(),

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
                SelectFilter::make('Status')
                    ->options(EnrolledStatus::class)
                    ->default(EnrolledStatus::PENDING->value),
                SelectFilter::make('grade_level')
                    ->options(GradeEnum::class),
                SelectFilter::make('strand_id')
                    ->label('By Strands')
                    ->relationship('strand', 'name'),

            ])
            ->actions([

                Tables\Actions\Action::make('approve')
                    // ->label('')
                    ->color('success')
                    ->modalHeading('Approve')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-hand-thumb-up')
                    ->form([
                        Select::make('section_id')
                            ->relationship(
                                name: 'section',
                                titleAttribute: 'name',
                            )
                            ->searchable()
                            ->preload()
                            // ->placeholder(fn ($record) => $record->section()->pluck('name', 'id'))
                            ->label('Section')
                            ->required(),
                    ])
                    ->action(
                        function (Enrollment $record) {
                            $record->update([
                                'section_id' => $record->section_id,
                                'status'    => EnrolledStatus::ENROLLED,
                            ]);
                            if ($section = $record->section) {
                                $subjects = $section->subjects()->pluck('id');
                                $record->subjects()->syncWithoutDetaching($subjects);
                            }
                            Notification::make()
                                ->title('Student Approved Successfully!')
                                ->icon('heroicon-o-check-circle')
                                ->success()
                                ->send();
                            $record->save();
                            return $record;
                        }
                    )->visible(function (Enrollment $record) {
                        return $record->status == EnrolledStatus::PENDING;
                    }),
                Tables\Actions\Action::make('reject')
                    // ->label('')
                    ->modalHeading('Reject')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-hand-thumb-down')
                    ->action(function ($record) {
                        Notification::make()
                            ->title('Rejected')
                            ->icon('heroicon-o-x-circle')
                            ->danger()
                            ->send();
                        $record->update([
                            'status' => EnrolledStatus::PENDING,
                        ]);
                    })->visible(function ($record) {
                        return $record->status == EnrolledStatus::ENROLLED;
                    }),
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
            // SectionRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
            'view' => Pages\ViewEnrollment::route('/{record}'),
            'edit' => Pages\EditEnrollment::route('/{record}/edit'),
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
