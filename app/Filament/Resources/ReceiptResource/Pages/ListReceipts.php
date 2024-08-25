<?php
namespace App\Filament\Resources\ReceiptResource\Pages;

use App\Filament\Resources\ReceiptResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use App\Models\Receipt;
use Filament\Actions;

class ListReceipts extends ListRecords
{
    protected static string $resource = ReceiptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'allReceipts' => Tab::make('All receipts')->modifyQueryUsing(function ($query) {
                return $query;
            })->badge(Receipt::count()),
            'accepted' => Tab::make('Accepted receipts')->modifyQueryUsing(function ($query) {
                return $query->where('status', 'accepted');
            })->badge(Receipt::where('status', 'accepted')->count())->indicatorColor('success'),
            'rejected' => Tab::make('Rejected receipts')->modifyQueryUsing(function ($query) {
                return $query->where('status', 'rejected');
            })->badge(Receipt::where('status', 'rejected')->count())->indicatorColor('warning'),
        ];
    }

}
