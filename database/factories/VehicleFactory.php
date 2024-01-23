<?php

namespace Database\Factories;

use Domain\TripTickets\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'name' => Str::headline($this->faker->words(2, true)),
            'additional_details' => $this->faker->sentence,
        ];
    }
}
