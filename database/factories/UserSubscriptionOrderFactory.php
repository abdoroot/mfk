<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserSubscriptionOrder;
class UserSubscriptionOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = UserSubscriptionOrder::class;

    public function definition()
    {
        $amount = $this->faker->randomFloat(2, 0, 1000);
        $tax = ($amount * 5) / 100;
        return [
            'provider_id' => 1,
            'customer_id' => 20,
            'plan_id' => 1,
            'amount' => $amount,
            'tax' => $tax,
            'discount' => 0,
            'tax' => $tax,
            'total_amount' => $amount+$tax,
        ];
    }
}
