<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Domain\Reports\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Domain\Reports\Models\Report>
 */
class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'requester_id' => User::factory()->create(),
            'filename' => $this->faker->words(3, true),
            'type' => $this->faker->words(3, true),
            'parameters' => [
                'from_date' => Carbon::now()->toDateTimeString(),
                'to_date' => Carbon::now()->addDay()->toDateTimeString(),
            ],
            'status' => 'pending',
        ];
    }
}
