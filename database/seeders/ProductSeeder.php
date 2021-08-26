<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::insert(
            [
                [
                    'name' => 'Product 1',
                    'available_stock' => 100
                ],
                [
                    'name' => 'Product 2',
                    'available_stock' => 100
                ],
                [
                    'name' => 'Product 3',
                    'available_stock' => 100
                ],
                [
                    'name' => 'Product 4',
                    'available_stock' => 100
                ],
                [
                    'name' => 'Product 5',
                    'available_stock' => 100
                ]
            ]
        );
    }
}
