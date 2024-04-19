<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function DelayedOrder(): HasOne
    {
        return $this->hasOne(DelayedOrder::class);
    }

    public function hasActiveDelayedOrder(): bool
    {
        return $this->delayedOrder()->where('status', DelayedOrder::STATUS['ASSIGNED'])->exists();
    }
}
