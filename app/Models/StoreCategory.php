<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;

class StoreCategory extends BaseModel implements HasMedia
{
    use HasFactory, HasRoles, InteractsWithMedia, SoftDeletes, HasTranslations;
    protected $table = 'store_categories';
    public $translatable = ['name', 'description'];
    protected $fillable = [
        'name',
        'description',
        'is_featured',
        'status',
        'color'
    ];
    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'status' => 'integer',
        'is_featured' => 'integer',
    ];

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id', 'id');
    }
    public function scopeList($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }


}
