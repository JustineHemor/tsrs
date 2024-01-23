<?php

namespace Domain\TripTickets\Models;

use Database\Factories\VehicleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $additional_details
 */
class Vehicle extends Model
{
    use HasFactory;

    protected static function newFactory(): VehicleFactory
    {
        return VehicleFactory::new();
    }
}
