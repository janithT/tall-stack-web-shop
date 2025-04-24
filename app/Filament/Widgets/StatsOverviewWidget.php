<?php
namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Product::count())
                ->description('All available products')
                ->icon('heroicon-o-cube'),

            Stat::make('Total Categories', Category::count())
                ->description('Product categories')
                ->icon('heroicon-o-folder'),

            Stat::make('Total orders', Order::count())
                ->description('Total orders placed')
                ->icon('heroicon-o-shopping-cart'),
        ];
    }

    protected function getFooter(): ?\Illuminate\Contracts\View\View
    {
        return view('filament.widgets.category-tags');
    }
}

