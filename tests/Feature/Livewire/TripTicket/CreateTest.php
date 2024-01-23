<?php

use App\Livewire\TripTicket\Create;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\RolesAndPermissionsSeeder;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    /** @var User $requester */
    $requester = User::factory()->create();
    $requester->assignRole('Trip Requester');

    $this->actingAs($requester);
});

it('show success page after creating trip ticket', function () {
    livewire(Create::class)
        ->set('form.name', 'Test name')
        ->set('form.mobile_number', '09876543212')
        ->set('form.passenger_count', '1')
        ->set('form.origin_location', 'Test origin')
        ->set('form.origin_date', Carbon::now()->format('Y-m-d'))
        ->set('form.origin_time', '13:00')
        ->set('form.drop_off_location', 'Test drop off')
        ->set('form.drop_off_date', Carbon::now()->format('Y-m-d'))
        ->set('form.drop_off_time', '14:00')
        ->set('form.purpose', 'Test purpose')
        ->call('create')
        ->assertSee('Trip Ticket Created!')
        ->assertSee('You will receive an email notification once the trip ticket has been approved or denied.');
});
