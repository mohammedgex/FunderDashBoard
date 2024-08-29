<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Models\Sale;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $activeNavigationIcon = 'heroicon-s-chart-bar';

    protected static ?string $navigationGroup = 'Funder Payment';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('property_id')
                    ->required()
                    ->relationship('property', 'name')
                    ->columnSpanFull(),
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->relationship('user', 'name')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->default('pending')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('property.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
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
                    ->action(function (Sale $record) {
                        // Execute the valid() logic here
                        $sale = Sale::find($record->id);
                        $sale->status = 'accepted';
                        $sale->save();
                        Notification::make()
                            ->title('Accepted')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->visible(fn(Sale $record) => $record->status === 'pending')
                    ->icon('heroicon-s-check-circle'),

                Action::make('Reject')
                    ->label('Reject')
                    ->button()
                    ->action(function (Sale $record) {
                        // Execute the notValid() logic here
                        $sale = Sale::find($record->id);
                        $sale->status = 'rejected';
                        $sale->save();
                        Notification::make()
                            ->title('Rejected')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('warning')
                    ->visible(fn(Sale $record) => $record->status === 'pending')
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

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
