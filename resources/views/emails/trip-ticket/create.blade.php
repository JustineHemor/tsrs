<x-mail::message>
<img src="{{ asset('img/teleserv.png') }}" style="width: 250px" alt="Pilipinas Teleserv Inc."/>
<h1 style="margin-top: 25px; margin-bottom: -20px;">New Trip Ticket: {{ $tripTicket->id }}</h1>
<x-mail::table>
|               |              |
| ------------- |:-------------|
|<b style="white-space: nowrap; padding-right: 10px;">Requested By:</b> | {{ $tripTicket->requester->name }} |
|<b style="white-space: nowrap; padding-right: 10px;">Contact Person:</b> | {{ $tripTicket->contact_person }} |
|<b style="white-space: nowrap; padding-right: 10px;">Mobile Number:</b> | {{ $tripTicket->contact_number }} |
|<b style="white-space: nowrap; padding-right: 10px;">Passenger Count:</b> | {{ $tripTicket->passenger_count }} |
|<b style="white-space: nowrap; padding-right: 10px;">Departure (Origin): </b> | {{ \Illuminate\Support\Str::squish($tripTicket->origin) }} |
|<b style="white-space: nowrap; padding-right: 10px;">Departure DateTime: </b> | {{ \Carbon\Carbon::parse($tripTicket->origin_datetime)->format('M d, Y h:i A') }} |
|<b style="white-space: nowrap; padding-right: 10px;">Destination (Drop Off): </b> | {{ \Illuminate\Support\Str::squish($tripTicket->drop_off) }} |
|<b style="white-space: nowrap; padding-right: 10px;">Destination DateTime: </b> | {{ \Carbon\Carbon::parse($tripTicket->drop_off_datetime)->format('M d, Y h:i A') }} |
|<b style="white-space: nowrap; padding-right: 10px;">Return Location (Pick Up): </b> | {{ \Illuminate\Support\Str::squish($tripTicket->pick_up) }} |
|<b style="white-space: nowrap; padding-right: 10px;">Return Location DateTime: </b> | {{ $tripTicket->pick_up_datetime ? \Carbon\Carbon::parse($tripTicket->pick_up_datetime)->format('M d, Y h:i A') : '' }} |
|<b style="white-space: nowrap; padding-right: 10px;">Vehicle:</b> | {{ $tripTicket->vehicle ? $tripTicket->vehicle->name : 'Any Vehicle' }} |
|<b style="white-space: nowrap; padding-right: 10px;">Driver:</b> | {{ $tripTicket->driver ? $tripTicket->driver->name . ' (' . $tripTicket->driver->nickname . ')' : 'Any Driver' }} |
|<b style="white-space: nowrap; padding-right: 10px;">Purpose:</b> | {{ $tripTicket->purpose }} |
</x-mail::table>

<x-mail::button :url="$url">
    View Trip Ticket
</x-mail::button>

</x-mail::message>


