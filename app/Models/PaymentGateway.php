<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PaymentGateway extends Model
{
    use HasFactory, HasTranslations;
    protected $table = 'payment_gateways';
    public $translatable = ['title'];
    protected $fillable = [
        'title',
        'type',
        'status',
        'is_test',
        'value',
        'live_value'
    ];
    protected $casts = [
        'title' => 'array',
        'is_test' => 'integer',
        'status' => 'integer',
    ];

}
