<?php

namespace Database\Seeders;

use App\Models\CustomerCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'RSUD'],
            ['name' => 'RS Swasta'],
            ['name' => 'Klinik'],
            ['name' => 'Lab Klinik'],
            ['name' => 'Puskesmas']
        ];

        foreach ($categories as $category) {
            CustomerCategory::firstOrCreate($category);
        }
    }
}
