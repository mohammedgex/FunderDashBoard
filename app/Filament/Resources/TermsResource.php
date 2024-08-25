<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TermsResource\Pages;
use App\Filament\Resources\TermsResource\RelationManagers;
use App\Models\Terms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TermsResource extends Resource
{
    protected static ?string $model = Terms::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3-center-left';
    protected static ?string $activeNavigationIcon = 'heroicon-s-bars-3-center-left';
    protected static ?string $navigationGroup = 'Funder Terms';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
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
            'index' => Pages\ListTerms::route('/'),
            'create' => Pages\CreateTerms::route('/create'),
            'edit' => Pages\EditTerms::route('/{record}/edit'),
        ];
    }
}
