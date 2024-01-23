<?php

namespace App\Http\Controllers;

use Domain\TripTickets\Models\TripTicket;
use Illuminate\Contracts\Foundation\Application as ApplicationAlias;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripTicketController extends Controller
{
    public function index(): ApplicationAlias|Factory|Application|View
    {
        $user_has_permission = Auth::user()->can('view-all-trip-ticket') || Auth::user()->can('view-trip-ticket');

        return view('trip-ticket.index', compact('user_has_permission'));
    }

    public function create(): ApplicationAlias|Factory|Application|View
    {
        $this->authorize('create-trip-ticket');

        return view('trip-ticket.create');
    }

    public function show(TripTicket $tripTicket): ApplicationAlias|View|Application|Factory
    {
        $user_can_view_component = Auth::user()->can('view-all-trip-ticket') || Auth::id() == $tripTicket->requester_id;

        return view('trip-ticket.show', compact('tripTicket', 'user_can_view_component'));
    }
}
