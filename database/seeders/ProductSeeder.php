<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Product 1', 'available_stock' => '1'],
            ['name' => 'Product 2', 'available_stock' => '99'],
            ['name' => 'Product 3', 'available_stock' => '999'],
            ['name' => 'Product 4', 'available_stock' => '99999']
        ];

        Products::insert($data);
    }
}
