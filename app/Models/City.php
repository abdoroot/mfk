<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class City extends Model
{
    use HasFactory,HasTranslations;
    protected $table = "cities";
    protected $primaryKey = "id";
    public $translatable = ['name'];
    
    protected $casts = [
        'state_id'  => 'integer',
    ];
    
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id','id');
    }
}
