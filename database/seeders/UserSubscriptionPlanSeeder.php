<?php

namespace Database\Seeders;
use App\Models\UserSubscriptionPlan;
use Illuminate\Database\Seeder;

class UserSubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Generate 10 fake user subscription plans
         UserSubscriptionPlan::factory()->count(10)->create();
    }
}
