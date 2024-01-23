<?php

use App\Livewire\SupplyRequest\Show;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Domain\Supplies\Actions\ApproveSupplyRequestAction;
use Domain\Supplies\Actions\DenySupplyRequestAction;
use Domain\Supplies\Actions\FulFillSupplyRequestAction;
use Domain\Supplies\Models\SupplyRequest;
use Domain\Supplies\StateMachines\Exceptions\InvalidStateActionException;
use Illuminate\Support\Facades\Session;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $this->seed(RolesAndPermissionsSeeder::class);
});

describe('approve supply request', function () {
    beforeEach(function () {
        /** @var User $approver */
        $approver = User::factory()->create();
        $approver->assignRole('Supplies Approver');

        $this->supplyRequest = SupplyRequest::factory()->create();

        $this->approvedSupplyRequest = SupplyRequest::factory()->approved()->create();

        $this->actingAs($approver);
    });

    it('displays error messages', function () {
        livewire(Show::class, ['supplyRequest' => $this->supplyRequest])
            ->set('form.supplyRequestItems.1.name', '')
            ->set('form.supplyRequestItems.1.quantity', '')
            ->call('confirmApprove')
            ->assertHasErrors('form.supplyRequestItems.1.name')
            ->assertHasErrors('form.supplyRequestItems.1.quantity');
    });

    it('redirects and creates session', function () {
        livewire(Show::class, ['supplyRequest' => $this->supplyRequest])
            ->call('confirmApprove')
            ->assertRedirect(route('supply-request.index'));

        Session::shouldReceive('put')->with('supply-request-updated');
    });

    it('calls an action class', function () {
        $this->mock(ApproveSupplyRequestAction::class)
            ->shouldReceive('execute')
            ->once();

        livewire(Show::class, ['supplyRequest' => $this->supplyRequest])
            ->call('confirmApprove');
    });

    it('does not redirect when action throws exception', function () {
        $this->mock(ApproveSupplyRequestAction::class)
            ->shouldReceive('execute')
            ->andThrow(InvalidStateActionException::class);

        livewire(Show::class, ['supplyRequest' => $this->approvedSupplyRequest])
            ->call('confirmApprove')
            ->assertNoRedirect();
    });

    it('returns forbidden exception response', function () {
        $this->actingAs(User::factory()->create());

        livewire(Show::class, ['supplyRequest' => $this->supplyRequest])
            ->call('confirmApprove')
            ->assertForbidden();
    });
});

describe('deny supply request', function () {
    beforeEach(function () {
        /** @var User $approver */
        $approver = User::factory()->create();
        $approver->assignRole('Supplies Approver');

        $this->supplyRequest = SupplyRequest::factory()->create();

        $this->approvedSupplyRequest = SupplyRequest::factory()->approved()->create();

        $this->actingAs($approver);
    });

    it('displays error messages', function () {
        livewire(Show::class, ['supplyRequest' => $this->supplyRequest])
            ->set('form.note', '')
            ->call('confirmDeny')
            ->assertHasErrors('form.note');
    });

    it('redirects and creates session', function () {
        livewire(Show::class, ['supplyRequest' => $this->supplyRequest])
            ->set('form.note', 'test')
            ->call('confirmDeny')
            ->assertRedirect(route('supply-request.index'));

        Session::shouldReceive('put')->with('supply-request-updated');
    });

    it('calls an action class', function () {
        $this->mock(DenySupplyRequestAction::class)
            ->shouldReceive('execute')
            ->once();

        livewire(Show::class, ['supplyRequest' => $this->supplyRequest])
            ->set('form.note', 'test')
            ->call('confirmDeny');
    });

    it('does not redirect when action throws exception', function () {
        $this->mock(DenySupplyRequestAction::class)
            ->shouldReceive('execute')
            ->andThrow(InvalidStateActionException::class);

        livewire(Show::class, ['supplyRequest' => $this->approvedSupplyRequest])
            ->set('form.note', 'test')
            ->call('confirmDeny')
            ->assertNoRedirect();
    });

    it('returns forbidden exception response', function () {
        $this->actingAs(User::factory()->create());

        livewire(Show::class, ['supplyRequest' => $this->supplyRequest])
            ->set('form.note', 'test')
            ->call('confirmDeny')
            ->assertForbidden();
    });
});

describe('fulfill supply request', function () {
    beforeEach(function () {
        /** @var User $approver */
        $approver = User::factory()->create();
        $approver->assignRole('Supplies Approver');

        $this->supplyRequest = SupplyRequest::factory()->create();

        $this->approvedSupplyRequest = SupplyRequest::factory()->approved()->create();

        $this->actingAs($approver);
    });

    it('redirects and creates session', function () {
        livewire(Show::class, ['supplyRequest' => $this->approvedSupplyRequest])
            ->call('confirmFulfill')
            ->assertRedirect(route('supply-request.index'));

        Session::shouldReceive('put')->with('supply-request-updated');
    });

    it('calls an action class', function () {
        $this->mock(FulFillSupplyRequestAction::class)
            ->shouldReceive('execute')
            ->once();

        livewire(Show::class, ['supplyRequest' => $this->approvedSupplyRequest])
            ->call('confirmFulfill');
    });

    it('does not redirect when action throws exception', function () {
        $this->mock(FulFillSupplyRequestAction::class)
            ->shouldReceive('execute')
            ->andThrow(InvalidStateActionException::class);

        livewire(Show::class, ['supplyRequest' => $this->supplyRequest])
            ->call('confirmFulfill')
            ->assertNoRedirect();
    });

    it('returns forbidden exception response', function () {
        $this->actingAs(User::factory()->create());

        livewire(Show::class, ['supplyRequest' => $this->approvedSupplyRequest])
            ->call('confirmFulfill')
            ->assertForbidden();
    });
});
