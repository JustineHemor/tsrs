@php
    use Domain\Supplies\Enums\Status;

    $color = match ($status) {
        Status::PENDING => 'text-amber-500',
        Status::APPROVED => 'text-green-500',
        Status::DENIED => 'text-red-500',
        Status::FULFILLED => 'text-lime-500'
    }
@endphp

<p class="mt-1 max-w-2xl leading-6 uppercase {{ $color }}">{{ $status }}</p>
