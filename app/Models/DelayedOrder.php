<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DelayedOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'order_id',
        'reason',
        'status',
    ];

    public const STATUS = [
        'ASSIGNED' => 'assigned',
        'RESOLVED' => 'resolved',
        'WITHOUT_OWNER' => 'without_owner'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

}
