<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Domain\TripTickets\Enums\Status;
use Domain\TripTickets\Models\TripTicket;
use Domain\TripTickets\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TripTicket>
 */
class TripTicketFactory extends Factory
{
    protected $model = TripTicket::class;

    public function definition(): array
    {
        return [
            'status' => Status::PENDING,
            'requester_id' => User::factory()->create(),
            'passenger_count' => $this->faker->numberBetween(4, 18),
            'contact_person' => $this->faker->name,
            'contact_number' => $this->faker->phoneNumber,
            'origin' => $this->faker->address,
            'drop_off' => $this->faker->address,
            'origin_datetime' => Carbon::now()->addDay(),
            'drop_off_datetime' => Carbon::now()->addDay()->addHours(2),
            'purpose' => $this->faker->sentence
        ];
    }

    public function approved(): Factory
    {
        return $this->state(function () {
            return [
                'status' => Status::APPROVED,
                'approved_at' => Carbon::now(),
                'approver_id' => User::factory()->create(),
            ];
        });
    }

    public function denied(): Factory
    {
        return $this->state(function () {
            return [
                'status' => Status::DENIED,
                'denied_at' => Carbon::now(),
                'denier_id' => User::factory()->create(),
            ];
        });
    }

    public function withVehicle(): Factory
    {
        return $this->state(function () {
            return [
                'vehicle_id' => Vehicle::factory()->create(),
            ];
        });
    }
}
