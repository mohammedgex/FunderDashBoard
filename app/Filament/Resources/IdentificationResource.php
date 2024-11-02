<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IdentificationResource\Pages;
use App\Models\Identification;
use Filament\Forms;
use Filament\Forms\Form;
use App\Notifications\Notifications;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use App\Models\User;
use Filament\Notifications\Notification as snackbar;
use Notification;

class IdentificationResource extends Resource
{
    protected static ?string $model = Identification::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $activeNavigationIcon = 'heroicon-s-identification';

    protected static ?int $navigationSort = 1;



    protected static ?string $navigationGroup = 'Funder Users';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identification')
                    ->schema([
                        Forms\Components\FileUpload::make('front_side')
                            ->required()
                            ->image()
                            ->directory(directory: 'uploads')
                            ->imageEditor()
                            ->loadingIndicatorPosition('left')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                        ,
                        Forms\Components\FileUpload::make('back_side')
                            ->required()
                            ->image()
                            ->directory(directory: 'uploads')
                            ->imageEditor()
                            ->loadingIndicatorPosition('left')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')

                        ,
                    ])
                    ->columns(2)
                ,
                Forms\Components\ToggleButtons::make('type')
                    ->columnSpanFull()
                    ->options([
                        "passport" => "Passport",
                        "national id" => "National Id",

                    ])
                    ->icons([
                        "passport" => "heroicon-s-identification",
                        "national id" => "heroicon-s-identification",
                    ])
                    ->columns(2)
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('notes')
                    ->columnSpanFull()
                    ->maxLength(255),
                Forms\Components\Select::make('user_id')
                    ->columnSpanFull()
                    ->required()
                    ->relationship('user', 'name')
                    ->suffixIcon('heroicon-s-user'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->url(fn($record) => UserResource::getUrl('edit', ['record' => $record->user_id]))
                    ->label('User name')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('user.image')
                    ->label('User phote')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('front_side'),
                Tables\Columns\ImageColumn::make('back_side'),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('notes')
                    ->searchable(),

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
                Action::make('Accept')
                    ->label('Accept')
                    ->button()
                    ->action(function (Identification $record) {
                        // Execute the valid() logic here
                        $identification = Identification::find($record->id);
                        $Identificati = Identification::find($record->id);
                        Notification::send(User::find($Identificati->user_id), new Notifications('identification accepted', 'the identification you have requested has been accepted', '50'));
                        $identification->status = 'valid';
                        $identification->save();
                        $user = User::find($identification->user_id);
                        $user->identification_verified_at = now();
                        $user->save();
                        snackbar::make()
                            ->title('Accepted')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->visible(fn(Identification $record) => $record->status === 'Waiting')
                    ->icon('heroicon-s-check-circle'),
                Action::make('Reject')
                    ->label('Reject')
                    ->button()
                    ->action(function (Identification $record) {
                        // Execute the notValid() logic here
                        $identification = Identification::find($record->id);
                        $Identificati = Identification::find($record->id);
                        Notification::send(User::find($Identificati->user_id), new Notifications('identification rejected', 'the identification you have requested has been rejected', '50'));

                        $identification->status = 'not valid';
                        $identification->notes = 'the identification is not clear';
                        $identification->save();
                        snackbar::make()
                            ->title('Rejected')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('warning')
                    ->visible(fn(Identification $record) => $record->status === 'Waiting')
                    ->icon('heroicon-s-x-circle'),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListIdentifications::route('/'),
            'create' => Pages\CreateIdentification::route('/create'),
            'edit' => Pages\EditIdentification::route('/{record}/edit'),
        ];
    }
}
