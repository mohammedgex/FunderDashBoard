<?php

namespace App\Filament\Resources\IdentificationResource\Pages;
use Filament\Resources\Components\Tab;
use App\Models\Identification;
use App\Filament\Resources\IdentificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIdentifications extends ListRecords
{
    protected static string $resource = IdentificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'allReceipts' => Tab::make('All Identifications')->modifyQueryUsing(function ($query) {
                return $query;
            })->badge(Identification::count()),
            'accepted' => Tab::make('Valid Identifications')->modifyQueryUsing(function ($query) {
                return $query->where('status', 'valid');
            })->badge(Identification::where('status', 'valid')->count())->indicatorColor('success'),
            'rejected' => Tab::make('Invalid Identifications')->modifyQueryUsing(function ($query) {
                return $query->where('status', 'not valid');
            })->badge(Identification::where('status', 'not valid')->count())->indicatorColor('warning'),
        ];
    }
}
