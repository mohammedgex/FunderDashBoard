<?php

namespace App\Filament\Widgets;
use App\Models\User;
use App\Models\Property;
use App\Models\Receipt;
use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Today\'s users', User::whereDate('created_at', Carbon::today())->count())->chart([
                1,
                3,
                5,
                20,
                40,
            ])->color('success'),
            Stat::make('Today\'s receipts', Receipt::whereDate('created_at', Carbon::today())->count())->chart([
                1,
                3,
                5,
                20,
                40,
            ])->color('success'),
            Stat::make('Today\'s sales', Sale::whereDate('created_at', Carbon::today())->count())->chart([
                1,
                3,
                5,
                20,
                40,
            ])->color('success'),
            Stat::make('All users', User::count())->chart([
                1,
                3,
                5,
                20,
                40,
            ]),
            Stat::make('All properties', Property::count())->chart([
                1,
                3,
                5,
                20,
                40,
            ]),
            Stat::make('All receipts', Receipt::count())->chart([
                1,
                3,
                5,
                20,
                40,
            ]),

        ];
    }
}
