<?php

use App\Livewire\TripTicket\Show;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Domain\TripTickets\Actions\ApproveTripTicketAction;
use Domain\TripTickets\Actions\CancelTripTicketAction;
use Domain\TripTickets\Actions\DenyTripTicketAction;
use Domain\TripTickets\Models\TripTicket;
use Domain\TripTickets\StateMachines\Exceptions\InvalidStateActionException;
use Illuminate\Support\Facades\Session;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

describe('approve trip ticket', function () {
    beforeEach(function () {
        /** @var User $approver */
        $approver = User::factory()->create();
        $approver->assignRole('Trip Approver');

        $this->tripTicket = TripTicket::factory()->create();

        $this->approvedTripTicket = TripTicket::factory()->approved()->create();

        $this->actingAs($approver);
    });

    it('redirects and creates session', function () {
        livewire(Show::class, ['tripTicket' => $this->tripTicket])
            ->call('confirmApprove')
            ->assertRedirect(route('trip-ticket.index'));

        Session::shouldReceive('put')->with('trip-ticket-updated');
    });

    it('calls an action class', function () {
        $this->mock(ApproveTripTicketAction::class)
            ->shouldReceive('execute')
            ->andReturn($this->tripTicket)
            ->once();

        livewire(Show::class, ['tripTicket' => $this->tripTicket])
            ->call('confirmApprove');
    });

    it('does not redirect when action throws exception', function () {
        $this->mock(ApproveTripTicketAction::class)
            ->shouldReceive('execute')
            ->andThrow(InvalidStateActionException::class);

        livewire(Show::class, ['tripTicket' => $this->approvedTripTicket])
            ->call('confirmApprove')
            ->assertNoRedirect();
    });
});

describe('cancel trip ticket', function () {
    beforeEach(function () {
        /** @var User $requester */
        $requester = User::factory()->create();
        $requester->assignRole('Trip Requester');

        $this->tripTicket = TripTicket::factory()->create([
            'requester_id' => $requester,
        ]);

        $this->deniedTripTicket = TripTicket::factory()->denied()->create([
            'requester_id' => $requester,
        ]);

        $this->actingAs($requester);
    });

    it('redirects and creates session', function () {
        livewire(Show::class, ['tripTicket' => $this->tripTicket])
            ->call('confirmCancel')
            ->assertRedirect(route('trip-ticket.index'));

        Session::shouldReceive('put')->with('trip-ticket-updated');
    });

    it('calls an action class', function () {
        $this->mock(CancelTripTicketAction::class)
            ->shouldReceive('execute')
            ->andReturn($this->tripTicket)
            ->once();

        livewire(Show::class, ['tripTicket' => $this->tripTicket])
            ->call('confirmCancel');
    });

    it('does not redirect when action throws exception', function () {
        $this->mock(CancelTripTicketAction::class)
            ->shouldReceive('execute')
            ->andThrow(InvalidStateActionException::class);

        livewire(Show::class, ['tripTicket' => $this->deniedTripTicket])
            ->call('confirmCancel')
            ->assertNoRedirect();
    });
});

describe('deny trip ticket', function () {
    beforeEach(function () {
        /** @var User $approver */
        $approver = User::factory()->create();
        $approver->assignRole('Trip Approver');

        $this->tripTicket = TripTicket::factory()->create();

        $this->approvedTripTicket = TripTicket::factory()->approved()->create();

        $this->actingAs($approver);
    });

    it('redirects and creates session', function () {
        livewire(Show::class, ['tripTicket' => $this->tripTicket])
            ->set('form.remarks', 'test')
            ->call('confirmDeny')
            ->assertRedirect(route('trip-ticket.index'));

        Session::shouldReceive('put')->with('trip-ticket-updated');
    });

    it('calls an action class', function () {
        $this->mock(DenyTripTicketAction::class)
            ->shouldReceive('execute')
            ->andReturn($this->tripTicket)
            ->once();

        livewire(Show::class, ['tripTicket' => $this->tripTicket])
            ->set('form.remarks', 'test')
            ->call('confirmDeny');
    });

    it('does not redirect when action throws exception', function () {
        $this->mock(DenyTripTicketAction::class)
            ->shouldReceive('execute')
            ->andThrow(InvalidStateActionException::class);

        livewire(Show::class, ['tripTicket' => $this->approvedTripTicket])
            ->set('form.remarks', 'test')
            ->call('confirmDeny')
            ->assertNoRedirect();
    });
});
