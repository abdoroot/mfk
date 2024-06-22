<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

     protected $fillable = [
        'guest_id','user_id', 'item_id', 'quantity',
    ];
}
