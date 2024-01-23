<?php

use App\Events\SupplyRequestCreated;
use App\Livewire\SupplyRequest\Create;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Facades\Event;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    /** @var User $requester */
    $requester = User::factory()->create();
    $requester->assignRole('Supplies Requester');

    $this->actingAs($requester);
});

it('validates component model', function () {
    livewire(Create::class)
        ->set('items', [[
            'name' => '',
            'specified_name' => '',
            'quantity' => '2 pcs',
            'purpose' => '',
        ]])
        ->call('create')
        ->assertHasErrors('items.0.name')
        ->assertHasErrors('items.0.purpose');
});

it('dispatches an event after creating supply request', function () {
    Event::fake();

    livewire(Create::class)
        ->set('items', [[
            'name' => 'Lorem',
            'specified_name' => '',
            'quantity' => '2 pcs',
            'purpose' => ' Ipsum',
        ]])
        ->set('remarks', 'Lorem Ipsum')
        ->call('create');

    Event::assertDispatched(SupplyRequestCreated::class);
});
