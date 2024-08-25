<?php

namespace App\Filament\Widgets;
use App\Filament\Resources\ReceiptResource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Notifications\Notification;
use App\Models\Receipt;
use App\Models\Funder;
use Filament\Tables\Actions\Action;

class LastestReceipts extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 2;


    public function table(Table $table): Table
    {
        return $table
            ->query(
                ReceiptResource::getEloquentQuery()->where('status', 'pending')
            )

            ->defaultSort('created_at', 'desc')
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

                    $receipt->status = 'accepted';
                    $receipt->save();

                    Notification::make()
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
                    $receipt->status = 'rejected';
                    $receipt->save();
                    Notification::make()
                        ->title('Rejected')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->color('warning')
                ->visible(fn(Receipt $record) => $record->status === 'pending')
                ->icon('heroicon-s-x-circle'),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('property.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('count_sheres')
                    ->suffix(' shares')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('method')
                ,
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('receipt_number')
                    ->prefix('#')
                ,
                Tables\Columns\TextColumn::make('deposit_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deposited_amount')
                    ->suffix(' EGP')
                ,
                Tables\Columns\BadgeColumn::make('status')
                ,
            ]);
    }
}
