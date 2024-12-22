<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    protected $fillable = ['order_id', 'tracking_number', 'status'];
    
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public static function generateTrackingNumber()
    {
        return 'TRK-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);
    }
}
