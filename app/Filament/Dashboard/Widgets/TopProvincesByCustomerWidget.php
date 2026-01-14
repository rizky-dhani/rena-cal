<?php

namespace App\Filament\Dashboard\Widgets;

use App\Models\Customer;
use App\Models\Province;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TopProvincesByCustomerWidget extends BaseWidget
{
    protected static ?string $heading = 'Top 10 Provinces by Customer Count';
    protected static ?string $pollingInterval = null;
    protected int|string|array $columnSpan = 2;
    protected ?string $maxHeight = '300px';

    public static function canView(): bool
    {
        $user = auth()->user();

        return $user && $user->hasRole(['Super Admin', 'Head', 'Admin']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Province::query()
                    ->select('provinces.id', 'provinces.name', 'provinces.code', \DB::raw('COUNT(customers.id) as customer_count'))
                    ->leftJoin('customers', 'provinces.code', '=', 'customers.province_id')
                    ->groupBy('provinces.id', 'provinces.name', 'provinces.code')
                    ->orderBy('customer_count', 'desc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Province')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_count')
                    ->label('Number of Customers')
                    ->numeric()
                    ->sortable(),
            ])
            ->paginated(false)
            ->striped();
    }
}