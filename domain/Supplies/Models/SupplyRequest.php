<?php

namespace Domain\Supplies\Models;

use App\Models\User;
use Carbon\Carbon;
use Database\Factories\SupplyRequestFactory;
use Domain\Supplies\Enums\Status;
use Domain\Supplies\StateMachines\Approved;
use Domain\Supplies\StateMachines\Base\SupplyRequestStateContract;
use Domain\Supplies\StateMachines\Denied;
use Domain\Supplies\StateMachines\Fulfilled;
use Domain\Supplies\StateMachines\Pending;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property Status $status
 * @property int $requester_id
 * @property string $note
 * @property string $remarks
 * @property Carbon $approved_at
 * @property Carbon $denied_at
 * @property Carbon $fulfilled_at
 * @property int $approver_id
 * @property int $denier_id
 * @property int $fulfiller_id
 * @property User $requester
 * @property User $approver
 * @property User $denier
 * @property User $fulfiller
 * @property Collection $items
 * @property Carbon $created_at
 */
class SupplyRequest extends Model
{
    use HasFactory;

    protected static function newFactory(): SupplyRequestFactory
    {
        return SupplyRequestFactory::new();
    }

    protected $casts = [
        'status' => Status::class,
        'approved_at' => 'datetime',
        'denied_at' => 'datetime',
        'fulfilled_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    public function state(): SupplyRequestStateContract
    {
        return  match ($this->status) {
            Status::PENDING => new Pending($this),
            Status::APPROVED => new Approved($this),
            Status::DENIED => new Denied($this),
            Status::FULFILLED => new Fulfilled($this),
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

    public function fulfiller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fulfiller_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(SupplyRequestItem::class);
    }
}
