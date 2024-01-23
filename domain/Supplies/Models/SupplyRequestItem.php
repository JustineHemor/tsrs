<?php

namespace Domain\Supplies\Models;

use Database\Factories\SupplyRequestItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $supply_request_id
 * @property string $name
 * @property string $purpose
 * @property string $quantity
 */
class SupplyRequestItem extends Model
{
    use HasFactory;

    protected static function newFactory(): SupplyRequestItemFactory
    {
        return SupplyRequestItemFactory::new();
    }

    public function supply_request(): BelongsTo
    {
        return $this->belongsTo(SupplyRequest::class);
    }
}
