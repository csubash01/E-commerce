<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords\Tab;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\OrderResource\Widgets\OrderStats;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderStats::class,
        ];
    }

    // protected function getFooterWidgets(): array
    // {
    //     return [
    //         OrderStats::class,
    //     ];
    // }

    public function getTabs(): array
    {
        return [
            null => Tab::make(('All')),
            'new' => Tab::make('New')->query(fn($query) => $query->where('status', 'new')),
            'processing' => Tab::make()->query(fn($query) => $query->where('status', 'processing')),
            'shipped' => Tab::make()->query(fn($query) => $query->where('status', 'shipped')),
            'delivered' => Tab::make()->query(fn($query) => $query->where('status', 'delivered')),
            'cancelled' => Tab::make()->query(fn($query) => $query->where('status', 'cancelled')),

        ];
    }
}
