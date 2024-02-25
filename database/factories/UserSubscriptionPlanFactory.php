<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserSubscriptionPlan;

class UserSubscriptionPlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserSubscriptionPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = [
            'ar' => $this->faker->word,
            'en' => $this->faker->word
        ];

        $description = [
            'ar' => $this->faker->text,
            'en' => $this->faker->text
        ];

        return [
            'provider_id' => 1,
            'my_home_id' => null,
            'title' => $title,
            'status' => 1,
            'category_id' => 10,
            'subcategory_id' => 34,
            'amount' => $this->faker->randomFloat(2, 0, 1000),
            'plan_type' => "monthly",
            'description' => $description,
        ];
    }
}
