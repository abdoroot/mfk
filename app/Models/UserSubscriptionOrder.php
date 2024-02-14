<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserSubscriptionOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_subscription_orders';

    protected $fillable = [
        'customer_id',
        'plan_id',
        'provider_id',
        'date',
        'start_at',
        'end_at',
        'amount',
        'discount',
        'coupon_id',
        'total_amount',
        'description',
        'status',
        'address',
        'payment_id',
    ];

    protected $casts = [
        'customer_id' => 'integer',
        'plan_id' => 'integer',
        'provider_id' => 'integer',
        'amount' => 'double',
        'discount' => 'double',
        'total_amount' => 'double',
        'coupon_id' => 'integer',
        'payment_id' => 'integer',
    ];

    protected $dates = ['date', 'start_at', 'end_at'];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function plan()
    {
        return $this->belongsTo(UserSubscriptionPlan::class, 'plan_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function scopeMyBooking($query){
        $user = auth()->user();
        if($user->hasRole('admin') || $user->hasRole('demo_admin')) {
            return $query;
        }

        if($user->hasRole('provider')) {
            return $query->where('provider_id', $user->id);
        }

        if($user->hasRole('user')) {
            return $query->where('customer_id', $user->id);
        }

        if($user->hasRole('handyman')) {
            return $query->whereHas('handymanAdded',function ($q) use($user){
                $q->where('handyman_id',$user->id);
            });
        }

        return $query;
    }
}
