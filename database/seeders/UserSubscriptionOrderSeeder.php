<?php

namespace Database\Seeders;

use App\Models\UserSubscriptionOrder;
use Illuminate\Database\Seeder;

class UserSubscriptionOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate 100 fake user subscription order
        UserSubscriptionOrder::factory()->count(100)->create();
    }
}
