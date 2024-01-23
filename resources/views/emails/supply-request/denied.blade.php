<x-mail::message>
<img src="{{ asset('img/teleserv.png') }}" style="width: 250px" alt="Pilipinas Teleserv Inc."/>
<h1 style="margin-top: 25px; margin-bottom: -20px;">Supply Request Approved: {{ $supplyRequest->id }}</h1>
<p style="margin-top: 35px; margin-bottom: -20px;">Requester: {{ $supplyRequest->requester->name }}</p>
<p style="margin-top: 20px; margin-bottom: -20px;">Remarks: {{ $supplyRequest->remarks }}</p>
<p style="margin-top: 20px; margin-bottom: -20px;">Note: {{ $supplyRequest->note }}</p>

<x-mail::table>
| Quantity       | Name         | Purpose  |
| ------------- | ------------- | ------------- |
@foreach($supplyRequest->items as $item)
| {{ $item->quantity }}     | {{ $item->name }}      | {{ $item->purpose }}      |
@endforeach
</x-mail::table>

<x-mail::button :url="$url">
    View Supply Request
</x-mail::button>

</x-mail::message>


