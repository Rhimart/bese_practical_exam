<?php

namespace Tests;

use App\Models\Products;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * This function create user
     *
     * @return void
     */
    public function createUser() {

        $user = User::factory()->create([
            'email' => 'rhimartbravo@gmail.com',
            'password' => bcrypt('Test123$$'),
        ]);
        return $user;
    }
/**
     * This function create product
     *
     * @return void
     */
    public function createproduct() {

        $products = Products::factory()->create([
            'name' => 'Sample',
            'available_stock' => 999,
        ]);
        return $products;
    }
}
