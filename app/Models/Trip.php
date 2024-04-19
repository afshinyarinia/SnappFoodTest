<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status',
        'created_at',
        'updated_at'
    ];

    public const STATUS = [
        'ASSIGNED' => 'assigned',
        'AT_VENDOR' => 'at_vendor',
        'PICKED' => 'picked',
        'DELIVERED' => 'delivered'
    ];

    public function setStatusAttribute(string $value): void
    {
        if (!in_array($value, self::STATUS)) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->attributes['status'] = $value;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
