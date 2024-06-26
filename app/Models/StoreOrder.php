<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StoreOrder extends Model
{
    use HasFactory, SoftDeletes;

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

    public function scopeMyOrder($query){
        $user = auth()->user();
        if($user->hasRole('admin') || $user->hasRole('demo_admin')) {
            return $query;
        }

        if($user->hasRole('user')) {
            return $query->where('customer_id', $user->id);
        }
        return $query;
    }

    public function getFormattedItemsAttribute()
    {
        $items = [];

        if (!is_null($this->items)) {
            foreach ($this->items as $item) {
                $data = StoreItem::find($item['id']);
                $itemName = $data->name ?? __("messages.unknown");
                $tempItem = [
                    "id" => $item['id'],
                    "name" => $itemName,
                    "price" => $item['price'],
                    "amount" => $item['price'],
                    "quantity" => $item['quantity'],
                    'attachments' => getAttachments($data->getMedia('store_item_attachment')), 
                ];
                array_push($items,$tempItem);
            }
        }
        return $items;
    }
}
