<?php

namespace Database\Factories;

use App\Models\StoreItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreItemFactory extends Factory
{

    protected $model = StoreItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => [
                'ar' => $this->faker->name,
                'en' => $this->faker->name,
            ],
            'provider_id' => 1,
            'status' => 1,
            'category_id' => $this->faker->numberBetween(1,10),
            'subcategory_id' => $this->faker->numberBetween(1,10),
            'price' => $this->faker->numberBetween(20,300),
            'description' => [
                'ar' => $this->faker->text,
                'en' => $this->faker->text,
            ]
        ];
    }
}
