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
use Doctrine\DBAL\Schema\Column;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EnrollmentResource\Pages;
use App\Filament\Resources\EnrollmentResource\RelationManagers\SectionRelationManager;
use App\Filament\Resources\EnrollmentResource\RelationManagers\SubjectsRelationManager;
use PhpParser\Node\Stmt\Label;

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

    if($count == 0){
        return null;
    }
    return $count;
}

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Forms\Components\Section::make('Select Grade to Enroll')
                    ->schema([
                            Forms\Components\Section::make()
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
                        Forms\Components\Section::make('Personal Information')
                            ->schema([
                                Forms\Components\FileUpload::make('profile_image')
                                // ->avatar()
                                ->previewable()
                                ->imagePreviewHeight(200)
                                ->imageEditor()
                                ->image()
                                ->columnSpanFull(),
                                Forms\Components\TextInput::make('first_name')
                                    ->placeholder('first name')
                                    ->required(),

                                Forms\Components\TextInput::make('middle_name')
                                    ->placeholder('middle name'),

                                Forms\Components\TextInput::make('last_name')
                                    ->placeholder('last name')
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



                            Forms\Components\Section::make('Personal Address')
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
                                    ->placeholder('zip code')
                                    ->numeric(),

                                Forms\Components\TextInput::make('status_type')
                                    ->hidden()
                                    ->required()
                                    ->numeric()
                                    ->default(1),
                                    ])
                                    ->columns(2),


                                    Forms\Components\Section::make('Incase of Emergency')
                                    ->schema([
                                Forms\Components\TextInput::make('guardian_name')
                                ->label('Parent \ Guardian name')
                                ->placeholder('parent\guardian name')
                                ->required(),
                                    Forms\Components\TextInput::make('incaseof_emergency')
                                    ->label('Contact Number')
                                    ->placeholder('contact number')
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
                    ->color(fn ($state): string => match($state){
                        'Set ID' => 'danger',
                         $state => 'warning'
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('strand.name')
                    ->default('No Strand')
                    ->color(fn ($state) => match($state){
                        'No Strand' => 'danger',
                        $state => 'warning'
                    })
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(['first_name', 'middle_name', 'last_name'])
                    ->sortable(['middle_name', 'first_name', 'last_name']),
                Tables\Columns\TextColumn::make('section.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('grade_level')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('middle_name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('last_name')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('email')
                //     // ->unique(table: 'enrollments', column: 'email')
                //     ->copyable()
                //     ->copyMessage('Email address copied')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('birthdate')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('gender')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('civil_status')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('contact_number')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('religion')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('facebook_url')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('purok')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('sitio_street')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('barangay')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('municipality')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('province')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('zip_code')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('status_type')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('guardian_name')
                //     ->searchable(),
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
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),

                    // Tables\Actions\Action::make('approve')
                    // // ->label('')
                    // ->color('success')
                    // ->modalHeading('Approve')
                    // ->requiresConfirmation()
                    // ->icon('heroicon-o-hand-thumb-up')
                    // ->action(fn ($record) => $record->update([
                    //     'status'    => EnrolledStatus::ENROLLED,
                    // ])),
                    Tables\Actions\Action::make('approve')
                    // ->label('')
                    ->color('success')
                    ->modalHeading('Approve')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-hand-thumb-up')
                    ->form([
                        Select::make('section_id')
                        ->relationship(name: 'section',
                        titleAttribute: 'name',
                        )
                        ->searchable()
                        ->preload()
                        // ->placeholder(fn ($record) => $record->section()->pluck('name', 'id'))
                        ->label('Section')
                        ->required(),
                    ])
                    ->action(function (Enrollment $record){
                        $record->update([
                            'section_id' => $record->section_id,
                            'status'    => EnrolledStatus::ENROLLED,
                        ]);
                        if($section = $record->section) {
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
                )->visible(function (Enrollment $record){
                    return $record->status == EnrolledStatus::PENDING;
                }),
                    Tables\Actions\Action::make('reject')
                    // ->label('')
                    ->modalHeading('Reject')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-hand-thumb-down')
                    ->action(function ($record){
                        Notification::make()
                        ->title('Rejected')
                        ->icon('heroicon-o-X-circle')
                        ->danger()
                        ->send();
                        $record->update([
                            'status' => EnrolledStatus::PENDING,
                        ]);
                    })->visible(function ($record){
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
