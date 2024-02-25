<?php

namespace Database\Factories;

use App\Models\StoreItem;
use App\Models\StoreOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreOrderFactory extends Factory
{
    protected $model = StoreOrder::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $items = [];
        $total = 0;
        $tax = 0;
        for ($i = 0; $i < 10; $i++) {
            $pr = $this->faker->numberBetween(0, 300);
            $total += $pr;
            $item = [
                "id" => $this->faker->numberBetween(1, 10),
                "quantity" => 1,
                "price" => $pr,
            ];
            array_push($items, $item);
        }

        $tax = ($total*5)/100;

        return [
            "customer_id" => 10,
            "items" => $items,
            "amount" => $total,
            "tax" => $tax,
            "discount" => 0,
            "total_amount" => $total + $tax,
            "shipping_address" => $this->faker->address,
            "payment_type" => $this->faker->randomElement(['cash','stripe']),
        ];

    }
}
