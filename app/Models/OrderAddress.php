<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'city',
        'street_address',
        'state',
        'postal_code',
        'country'
    ];

    /**
     * Get the order that owns the address
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
} 