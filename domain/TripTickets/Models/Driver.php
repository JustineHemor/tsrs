<?php

namespace Domain\TripTickets\Models;

use Database\Factories\DriverFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $nickname
 * @property int $id
 */
class Driver extends Model
{
    use HasFactory;

    protected static function newFactory(): DriverFactory
    {
        return DriverFactory::new();
    }
}
