<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'vendor_id',
        'order_number',
        'status',
        'total',
        'delivery_time',
        'created_at',
        'updated_at'
    ];

    public const STATUS = [
      "DONE" => "done",
      "DELAYED" => "delayed",
      "READY" => "ready",
      "WAITING" => "waiting",
      "ON_THE_WAY" => "on_the_way"
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function trip(): HasOne
    {
        return $this->hasOne(Trip::class);
    }

    public function delayReports(): HasMany
    {
        return $this->hasMany(DelayReport::class);
    }

    public function delayedStatus(): HasOne
    {
        return $this->hasOne(DelayedOrder::class);
    }
}
