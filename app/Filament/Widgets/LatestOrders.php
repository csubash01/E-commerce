<?php

namespace App\Filament\Widgets;

use Dom\Text;
use Filament\Tables;
use App\Models\Order;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\OrderResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';

    protected static  ?int $sort = 2;


    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')

            ->columns([
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label('Customer Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('grand_total')
                    ->label('Total Amount')
                    ->money('NPR')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'info' => 'new',
                        'warning' => 'processing',
                        'success' => ['shipped', 'delivered'],
                        'danger' => 'cancelled',
                    ])
                    ->icon(fn(string $state): string => match ($state) {
                        'new' => 'heroicon-o-sparkles',
                        'processing' => 'heroicon-o-arrow-path',
                        'shipped' => 'heroicon-o-truck',
                        'delivered' => 'heroicon-o-check-badge',
                        'cancelled' => 'heroicon-o-x-circle',
                    })
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('payment_status')
                    ->badge()
                    ->badge()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime()
                    ->sortable(),

            ])

            ->actions([
                Action::make('View Order')
                    ->label('View Order')
                    ->url(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record])),
            ]);
    }
}
