<?php

namespace App\Filament\Resources\PropertyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RentsRelationManager extends RelationManager
{
    protected static string $relationship = 'rents';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('start_date')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\TextInput::make('monthly_income')
                    ->required()
                    ->suffix("EGP")
                    ->maxLength(255),
                Forms\Components\DatePicker::make('end_date')
                    ->columnSpanFull()
                    ->required(),
                    Forms\Components\Toggle::make('status')
                    ->columnSpanFull()
                    ->default(true)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('monthly_income')
            ->columns([
                Tables\Columns\TextColumn::make('start_date'),
                Tables\Columns\TextColumn::make('monthly_income')->suffix(' EGP'),
                Tables\Columns\TextColumn::make('end_date'),
                Tables\Columns\ToggleColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
