<?php

namespace App\Livewire\Forms\Report;

use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Symfony\Contracts\Service\Attribute\Required;

class CreateForm extends Form
{
    #[Validate('required')]
    public ?string $from_date = null;
    public ?string $from_time = null;

    #[Validate('required')]
    public ?string $to_date = null;
    public ?string $to_time = null;

    #[Validate('required')]
    public ?string $type = null;
}
