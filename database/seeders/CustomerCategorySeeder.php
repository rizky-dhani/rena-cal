<?php

namespace Database\Seeders;

use App\Models\CustomerCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomerCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'RSUD',
                'slug' => Str::slug('RSUD'),
            ],
            ['name' => 'RS Swasta',
                'slug' => Str::slug('RS Swasta'),
            ],
            ['name' => 'Klinik',
                'slug' => Str::slug('Klinik'),
            ],
            ['name' => 'Lab Klinik',
                'slug' => Str::slug('Lab Klinik'),
            ],
            ['name' => 'Puskesmas',
                'slug' => Str::slug('Puskesmas'),
            ],
        ];

        foreach ($categories as $category) {
            CustomerCategory::firstOrCreate($category);
        }
    }
}
