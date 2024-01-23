<?php

namespace App\Livewire\Forms\TripTicket;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateForm extends Form
{
    #[Validate('required')]
    public string $name = '';
    #[Validate('required')]
    public string $mobile_number = '';
    #[Validate('required|int|min:1')]
    public int $passenger_count = 1;

    #[Validate('required')]
    public string $origin_location = '';
    #[Validate('required|date|after:yesterday')]
    public string $origin_date = '';
    #[Validate('required')]
    public string $origin_time = '';

    #[Validate('required')]
    public string $drop_off_location = '';
    #[Validate('required|date|after:yesterday')]
    public string $drop_off_date = '';
    #[Validate('required')]
    public string $drop_off_time = '';

    public string $pick_up_location = '';
    public string $pick_up_date = '';
    public string $pick_up_time = '';

    public ?int $vehicle_id = null;
    public ?int $driver_id = null;
    #[Validate('required')]
    public string $purpose = '';
}
