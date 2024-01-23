<?php

namespace Database\Factories;

use Domain\Supplies\Models\SupplyItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplyItemFactory extends Factory
{
    protected $model = SupplyItem::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->sentence,
        ];
    }
}
