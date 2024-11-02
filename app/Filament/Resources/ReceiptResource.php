<?php

namespace App\Filament\Resources;
use App\Models\User;
use App\Notifications\Notifications;
use App\Filament\Resources\ReceiptResource\Pages;
use App\Models\Receipt;
use App\Models\Funder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification as snackbar;
use Notification;



class ReceiptResource extends Resource
{
    protected static ?string $model = Receipt::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    protected static ?string $activeNavigationIcon = 'heroicon-s-receipt-percent';

    protected static ?string $navigationGroup = 'Funder Payment';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('count_sheres')
                    ->columnSpanFull()
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('method')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->columnSpanFull()
                    ->image()
                    ->required(),
                Forms\Components\TextInput::make('receipt_number')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('deposit_date')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\TextInput::make('deposited_amount')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('user_id')
                    ->columnSpanFull()
                    ->required()
                    ->relationship('user', 'name'),
                Forms\Components\Select::make('property_id')
                    ->columnSpanFull()
                    ->relationship('property', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->url(fn($record) => UserResource::getUrl('edit', ['record' => $record->user_id]))
                    ->sortable(),
                Tables\Columns\TextColumn::make('property.name')
                    ->color('success')
                    ->url(fn($record) => PropertyResource::getUrl('edit', ['record' => $record->property_id]))
                    ->sortable(),
                Tables\Columns\TextColumn::make('count_sheres')
                    ->suffix(' shares')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('method')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->openUrlInNewTab(true) // Opens the image in a new tab when clicked
                    // ->url(fn($record) => $record->image), // The image URL or path,
                    ,
                Tables\Columns\TextColumn::make('receipt_number')
                    ->prefix('#')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deposit_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deposited_amount')
                    ->suffix(' EGP')
                    ->searchable(),
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
                    ->action(function (Receipt $record) {
                        // Execute the accepted logic here
                        $receipt = Receipt::find($record->id);
                        $property = $receipt->property;

                        if ($property->funders->count() == $property->funder_count + $property->funder_count * 1 / 5) {
                            Notification::make()
                                ->title('The number of participants in this property has been completed')
                                ->warning()
                                ->send();
                        }

                        if ($property->funders->count() + $receipt->count_sheres > $property->funder_count + $property->funder_count * 1 / 5) {
                            Notification::make()
                                ->title('The purchase could not be completed because the number of available funders is ' . ($property->funder_count + $property->funder_count * 1 / 5 - $property->funders->count()))
                                ->warning()
                                ->send();
                        }

                        $fundercount = $property->funders->where('status', 'funder')->count();
                        $pendingcount = $property->funders->where('status', 'pending')->count();

                        for ($i = 0; $i < $receipt->count_sheres; $i++) {
                            if ($fundercount < $property->funder_count) {
                                Funder::create([
                                    'user_id' => $receipt->user_id,
                                    'property_id' => $property->id,
                                    'status' => 'funder',
                                ]);
                            } elseif ($pendingcount < intval($property->funder_count * 20 / 100)) {
                                Funder::create([
                                    'user_id' => $receipt->user_id,
                                    'property_id' => $property->id,
                                    'status' => 'pending',
                                ]);
                            }
                        }
                        Notification::send(User::find($receipt->user_id), new Notifications('receipt accepted', 'the payment receipt you have requested has been accepcted', '50'));
                        $receipt->status = 'accepted';
                        $receipt->save();

                        snackbar::make()
                            ->title('Accepted')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->visible(fn(Receipt $record) => $record->status === 'pending')
                    ->icon('heroicon-s-check-circle'),
                Action::make('Reject')
                    ->label('Reject')
                    ->button()
                    ->action(function (Receipt $record) {
                        // Execute the rejected logic here
                        $receipt = Receipt::find($record->id);
                        Notification::send(User::find($receipt->user_id), new Notifications('receipt rejected', 'the payment receipt you have requested has been rejected', '50'));
                        $receipt->status = 'rejected';
                        $receipt->save();
                        snackbar::make()
                            ->title('Rejected')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('warning')
                    ->visible(fn(Receipt $record) => $record->status === 'pending')
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
            'index' => Pages\ListReceipts::route('/'),
            'create' => Pages\CreateReceipt::route('/create'),
            'edit' => Pages\EditReceipt::route('/{record}/edit'),
        ];
    }
}
