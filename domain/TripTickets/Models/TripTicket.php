<?php

namespace Domain\TripTickets\Models;

use App\Models\User;
use Carbon\Carbon;
use Database\Factories\TripTicketFactory;
use Domain\TripTickets\Enums\Status;
use Domain\TripTickets\StateMachines\Approved;
use Domain\TripTickets\StateMachines\Base\TripTicketStateContract;
use Domain\TripTickets\StateMachines\Cancelled;
use Domain\TripTickets\StateMachines\Denied;
use Domain\TripTickets\StateMachines\Pending;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property Status $status
 * @property int $passenger_count
 * @property string $contact_person
 * @property string $contact_number
 * @property string $origin
 * @property Carbon $origin_datetime
 * @property string $drop_off
 * @property Carbon $drop_off_datetime
 * @property string $pick_up
 * @property Carbon $pick_up_datetime
 * @property string $remarks
 * @property int $requester_id
 * @property int $vehicle_id
 * @property int $driver_id
 * @property Carbon $approved_at
 * @property Carbon $denied_at
 * @property Carbon $cancelled_at
 * @property Driver $driver
 * @property Vehicle $vehicle
 * @property User $requester
 * @property User $approver
 * @property int $approver_id
 * @property User $denier
 * @property int $denier_id
 * @property string $purpose
 * @property Carbon $created_at
 */
class TripTicket extends Model
{
    use HasFactory;

    protected static function newFactory(): TripTicketFactory
    {
        return TripTicketFactory::new();
    }

    protected $casts = [
        'status' => Status::class,
        'approved_at' => 'datetime',
        'denied_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'origin_datetime' => 'datetime',
        'drop_off_datetime' => 'datetime',
        'pick_up_datetime' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function state(): TripTicketStateContract
    {
        return  match ($this->status) {
            Status::PENDING => new Pending($this),
            Status::APPROVED => new Approved($this),
            Status::DENIED => new Denied($this),
            Status::CANCELLED => new Cancelled($this),
        };
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function denier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'denier_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
