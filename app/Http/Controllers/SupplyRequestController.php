<?php

namespace App\Http\Controllers;

use Domain\Supplies\Models\SupplyRequest;
use Illuminate\Contracts\Foundation\Application as ApplicationAlias;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplyRequestController extends Controller
{
    public function index(): ApplicationAlias|Factory|Application|View
    {
        $user_has_permission = Auth::user()->can('view-supplies-requests') or Auth::user()->can('view-all-supplies-requests');

        return view('supply-request.index', compact('user_has_permission'));
    }

    public function create(): ApplicationAlias|Factory|Application|View
    {
        $this->authorize('create-supplies-request');

        return view('supply-request.create');
    }

    public function show(SupplyRequest $supplyRequest): ApplicationAlias|Factory|Application|View
    {
        $user_can_view_component = Auth::user()->can('view-all-supplies-requests') || Auth::id() == $supplyRequest->requester_id;

        return view('supply-request.show', compact('supplyRequest', 'user_can_view_component'));
    }
}
