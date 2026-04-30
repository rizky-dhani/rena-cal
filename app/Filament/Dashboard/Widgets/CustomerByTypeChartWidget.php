<?php

namespace App\Filament\Dashboard\Widgets;

use App\Models\Customer;
use Filament\Widgets\DoughnutChartWidget;

class CustomerByTypeChartWidget extends DoughnutChartWidget
{
    protected static ?int $sort = 5;

    protected static string $chartType = 'doughnut';

    protected int|string|array $columnSpan = 2;

    protected ?string $maxHeight = '300px';

    public ?string $filter = 'all';

    public function getHeading(): string
    {
        return __('customer_categories.widgets.by_types.heading');
    }

    protected function getFilters(): ?array
    {
        return [
            'all' => 'All Time',
            'year' => 'This Year',
            'month' => 'This Month',
            'week' => 'This Week',
        ];
    }

    public static function canView(): bool
    {
        $user = auth()->user();

        return $user && $user->hasRole(['Super Admin', 'Head', 'Admin']);
    }

    protected function getData(): array
    {
        $query = Customer::select('type', \DB::raw('count(*) as count'))
            ->groupBy('type')
            ->whereNotNull('type');

        switch ($this->filter) {
            case 'year':
                $query->whereYear('created_at', now()->year);
                break;
            case 'month':
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
                break;
            case 'week':
                $query->whereDate('created_at', '>=', now()->subWeek())
                    ->whereDate('created_at', '<=', now());
                break;
        }

        $customerTypes = $query->get();

        $labels = $customerTypes->pluck('type')->toArray();
        $counts = $customerTypes->pluck('count')->toArray();

        // Define distinct colors for each type
        $colors = [
            '#4F46E5', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6',
            '#EC4899', '#06B6D4', '#84CC16', '#F97316', '#6366F1',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Number of Customers',
                    'data' => $counts,
                    'backgroundColor' => $colors,
                    'borderColor' => '#fff',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
