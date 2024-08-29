<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use App\Models\Sale;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListSales extends ListRecords
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'allReceipts' => Tab::make('All Sales')->modifyQueryUsing(function ($query) {
                return $query;
            })->badge(Sale::count()),
            'accepted' => Tab::make('Accepted Sales')->modifyQueryUsing(function ($query) {
                return $query->where('status', 'accepted');
            })->badge(Sale::where('status', 'accepted')->count())->indicatorColor('success'),
            'rejected' => Tab::make('Rejected Sales')->modifyQueryUsing(function ($query) {
                return $query->where('status', 'rejected');
            })->badge(Sale::where('status', 'rejected')->count())->indicatorColor('warning'),
        ];
    }
}
