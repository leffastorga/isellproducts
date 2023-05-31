<?php

namespace Database\Seeders;

use App\Models\Payment\PaymentMethod;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create();

        PaymentMethod::create(['name' => 'Credit Card']);
        PaymentMethod::create(['name' => 'Paypal']);

    }
}
