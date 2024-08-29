<?php

namespace App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource;
use App\Filament\Resources\PropertyResource\Widgets\StatsOverview;
use App\Models\Property;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListProperties extends ListRecords
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // StatsOverview::class,
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'allReceipts' => Tab::make('all properties')->modifyQueryUsing(function ($query) {
                return $query;
            })->badge(Property::count()),
            'avaiable properties' => Tab::make('avalible properties')->modifyQueryUsing(function ($query) {
                return $query->where('status', 'avalible');
            })->badge(Property::where('status', 'avalible')->count())->indicatorColor('success'),
            'soldOut properties' => Tab::make('soldOut properties')->modifyQueryUsing(function ($query) {
                return $query->where('status', 'sold out');
            })->badge(Property::where('status', 'sold out')->count())->indicatorColor('warning'),
        ];
    }
}
