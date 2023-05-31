<?php

namespace Database\Seeders;

use App\Models\Payment\PaymentMethod;
use App\Models\Product\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create();

        PaymentMethod::create(['name' => 'Credit Card']);
        PaymentMethod::create(['name' => 'Paypal']);

        Product::factory(20)->create([
           'created_by' => $user->id
        ]);
    }
}
