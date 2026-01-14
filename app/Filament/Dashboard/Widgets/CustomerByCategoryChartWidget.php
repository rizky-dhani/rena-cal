<?php

namespace App\Filament\Dashboard\Widgets;

use App\Models\Customer;
use App\Models\CustomerCategory;
use Filament\Widgets\BarChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class CustomerByCategoryChartWidget extends BarChartWidget
{
    protected static ?int $sort = 4;
    public ?string $filter = 'all';
    protected int|string|array $columnSpan = 2;
    protected ?string $maxHeight = '300px';

    public function getHeading(): string
    {
        return __('customer_categories.widgets.by_categories.heading');
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
        // Get all customer categories
        $allCategories = CustomerCategory::all();

        // Initialize counts for all categories with 0
        $categoryCounts = [];
        foreach ($allCategories as $category) {
            $categoryCounts[$category->name] = 0;
        }

        $query = Customer::with('category');

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

        $customers = $query->get();

        // Count customers for each category
        foreach ($customers as $customer) {
            $categoryName = $customer->category?->name;

            if ($categoryName && array_key_exists($categoryName, $categoryCounts)) {
                $categoryCounts[$categoryName]++;
            } elseif ($categoryName) {
                // If category exists but wasn't in our initial list, add it
                $categoryCounts[$categoryName] = 1;
            }
        }

        // Prepare data for the chart ensuring all categories are represented
        $labels = array_keys($categoryCounts);
        $counts = array_values($categoryCounts);

        return [
            'datasets' => [
                [
                    'label' => 'Number of Customers',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
                        '#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                    ],
                    'borderColor' => '#fff',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
