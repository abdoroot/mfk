<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class StoreSubCategory extends BaseModel implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes, HasTranslations;
    protected $table = 'store_sub_categories';
    public $translatable = ['name', 'description'];
    protected $fillable = [
        'name',
        'description',
        'is_featured',
        'status',
        'store_category_id'
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'status' => 'integer',
        'is_featured' => 'integer',
        'store_category_id' => 'integer',
    ];
    public function category()
    {
        return $this->belongsTo('App\Models\StoreCategory', 'store_category_id', 'id')->withTrashed();
    }
    public function scopeList($query)
    {
        return $query->orderBy('deleted_at', 'asc');
    }
}
