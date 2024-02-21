<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;

class StoreItem extends Model implements  HasMedia
{
    use InteractsWithMedia,HasFactory,SoftDeletes,HasTranslations;

    protected $fillable = [
        'name',
        'category_id',
        'subcategory_id',
        'provider_id',
        'price',
        'discount',
        'status',
        'description',
        'is_featured',
        'added_by',
    ];

    public $translatable = ['name', 'description'];

    public function providers(){
        return $this->belongsTo('App\Models\User','provider_id','id')->withTrashed();
    }

    public function category(){
        return $this->belongsTo('App\Models\StoreCategory','category_id','id')->withTrashed();
    }

    public function subcategory(){
        return $this->belongsTo('App\Models\StoreSubCategory','subcategory_id','id')->withTrashed();
    }

    public function scopeMyItem($query)
    {
        if(auth()->user()->hasRole('admin')) {

            return $query->where('service_type', 'service')->withTrashed();
        }

        if(auth()->user()->hasRole('provider')) {
            return $query->where('provider_id', \Auth::id());
        }

        return $query;
    }
}
