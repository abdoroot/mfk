<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StoreOrder extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'store_orders';

    protected $fillable = [
        'customer_id',
        'items',
        'amount',
        'discount',
        'coupon_id',
        'total_amount',
        'tax',
        'description',
        'status',
        'address',
        'shipping_address',
        'payment_type',
        'payment_id'
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'items' => 'array',
        'amount' => 'double',
        'discount' => 'double',
        'total_amount' => 'double',
        'coupon_id' => 'integer',
        'payment_id' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
