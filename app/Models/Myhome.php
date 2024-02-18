<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Myhome extends Model
{
    use HasFactory,HasTranslations,SoftDeletes;

    protected $table = 'myhome';

    public $translatable = ['name','address'];

    
    protected $fillable = [
        "customer_id",
        'name',
        'status',
        'email',
        'phone',
        'start_date',
        'end_date',
        'address',
        'building_no',
        'flat_no',
        'maintenance_borne',
        'borne_type',
        'borne_amount',
    ];

    protected $casts = [
        'name' => 'json',
        'address' => 'json',
        'start_date' => 'date',
        'end_date' => 'date',
    ];


    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

}
