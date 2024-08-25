<?php

namespace App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\StatsOverviewWidget;

class ListProperties extends ListRecords
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // StatsOverviewWidget::class,
            Actions\CreateAction::make(),
        ];
    }
}
