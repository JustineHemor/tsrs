<?php

namespace Database\Factories;

use App\Models\User;
use Domain\Supplies\Enums\Status;
use Domain\Supplies\Models\SupplyRequest;
use Domain\Supplies\Models\SupplyRequestItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupplyRequest>
 */
class SupplyRequestFactory extends Factory
{
    protected $model = SupplyRequest::class;

    public function definition(): array
    {
        return [
            'status' => Status::PENDING,
            'requester_id' => User::factory()->create(),
            'remarks' => $this->faker->sentence,
        ];
    }

    public function approved(): Factory
    {
        return $this->state(function () {
            return [
                'status' => Status::APPROVED,
                'approver_id' => User::factory()->create(),
                'approved_at' => now(),
            ];
        });
    }

    public function configure(): static
    {
        return $this->afterCreating(function (SupplyRequest $supplyRequest) {
            SupplyRequestItem::factory()->create([
                'supply_request_id' => $supplyRequest->id,
                'name' => $this->faker->words(2, true),
                'quantity' => $this->faker->numberBetween(1, 9) . ' pcs',
                'purpose' => $this->faker->words(6, true),
            ]);
        });
    }
}
