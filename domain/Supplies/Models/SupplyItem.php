<?php

namespace Domain\Supplies\Models;

use Database\Factories\SupplyItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 */
class SupplyItem extends Model
{
    use HasFactory;

    protected static function newFactory(): SupplyItemFactory
    {
        return SupplyItemFactory::new();
    }
}
