<?php

namespace App\Filament\Resources;

use App\GradeEnum;
use Filament\Forms;
use Filament\Tables;
use App\EnrolledStatus;
use App\Models\Student;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Enrollment;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\FileUpload::make('profile_image')
                    ->avatar()
                    ->previewable()
                    ->imagePreviewHeight(500)
                    ->image()
                     ->afterStateUpdated(function ($state,Set $set) {
                      } ),
                    ]),
                Forms\Components\Section::make()
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('school_id')
                    ->placeholder('Set ID')
                    ->label('School ID')
                    ->required()
                     ->afterStateUpdated(function ($state,Set $set) {
                      } ),
                  Forms\Components\Select::make('strand.name')
                    ->relationship(name: 'strand', titleAttribute: 'name')
                    ->default('No Strand')
                     ->afterStateUpdated(function ($state,Set $set) {
                      } ),
                      Forms\Components\Select::make('section_id')
                      ->relationship(name: 'section', titleAttribute: 'name')
                      ->required()
                      ->placeholder('No Strand')
                       ->afterStateUpdated(function ($state,Set $set) {
                        } ),
                  Forms\Components\TextInput::make('grade_level')
                        ->required()
                         ->afterStateUpdated(function ($state,Set $set) {
                          } ),
                  Forms\Components\TextInput::make('full_name')
                    ->required()
                     ->afterStateUpdated(function ($state,Set $set) {
                      } ),
                  Forms\Components\TextInput::make('first_name')
                      ->required()
                       ->afterStateUpdated(function ($state,Set $set) {
                        } ),
                  Forms\Components\TextInput::make('last_name')
                  ->afterStateUpdated(function ($state,Set $set) {
                    } ),
                    Forms\Components\TextInput::make('email')
                    ->afterStateUpdated(function ($state,Set $set) {
                      } ),
                      Forms\Components\TextInput::make('birthdate')
                      ->afterStateUpdated(function ($state,Set $set) {
                        } ),
                        Forms\Components\TextInput::make('gender')
                        ->afterStateUpdated(function ($state,Set $set) {
                          } ),
                  Forms\Components\TextInput::make('civil_status')
                          ->afterStateUpdated(function ($state,Set $set) {
                            } ),
                  Forms\Components\TextInput::make('contact_number')
                            ->afterStateUpdated(function ($state,Set $set) {
                              } ),
                  Forms\Components\TextInput::make('religion')
                              ->afterStateUpdated(function ($state,Set $set) {
                                } ),
                  Forms\Components\TextInput::make('facebook_url')
                                ->afterStateUpdated(function ($state,Set $set) {
                                  } ),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Enrollment::where('status', EnrolledStatus::ENROLLED))
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
                ->options(EnrolledStatus::class),
                SelectFilter::make('grade_level')
                ->options(GradeEnum::class),
                SelectFilter::make('strand_id')
                ->label('By Strands')
                ->relationship('strand', 'name'),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                // ->mutateRecordDataUsing(function (array $data, Set $set): array {
                //     // dd($data);




                //     return $data;
                // }),
                Tables\Actions\Action::make('Qr')
                ->icon('heroicon-o-qr-code')
               ->modalContent(fn (Enrollment $record): View => view(
                  'filament.resources.student-resource.pages.view-qr-code',
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
            'index' => Pages\ListStudents::route('/'),
            'qr-code' => Pages\ViewQrCode::route('/{record}/teacher'),
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
