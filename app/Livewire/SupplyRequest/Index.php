<?php

namespace App\Livewire\SupplyRequest;

use App\Models\User;
use Domain\Supplies\Actions\GetSupplyRequestsAction;
use Domain\Supplies\Data\GetSupplyRequestsData;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public Collection $requesters;

    public ?int $requester_id = null;
    public string $status = '';
    public ?int $supply_request_id = null;

    public function render(GetSupplyRequestsAction $getSupplyRequestsAction): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $this->getRequesters();

        $supplyRequests = $getSupplyRequestsAction(new GetSupplyRequestsData(
            requester_id: $this->requester_id,
            status: $this->status,
            supply_request_id: $this->supply_request_id,
        ));

        return view('livewire.supply-request.index', [
            'supplyRequests' => $supplyRequests,
        ]);
    }

    public function updated(): void
    {
        $this->resetPage();
    }

    public function mount(): void
    {
        $this->checkSessionAlert();

        $this->getRequesters();
    }

    private function getRequesters(): void
    {
        $this->requesters = User::query()
            ->orderBy('name')
            ->get();
    }

    private function checkSessionAlert(): void
    {
        $id = Auth::id();

        if (Session::has('supply-request-updated-'.$id)) {
            $this->alert('success', Session::get('supply-request-updated-'.$id));

            Session::forget('supply-request-updated-'.$id);
        }
    }
}
