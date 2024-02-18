<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class UserSubscriptionPlan extends Model
{
    use HasFactory,HasTranslations;

    protected $table = "user_subscriptions_plans";


    protected $fillable = [
        'provider_id','my_home_id','title', 'amount','status','description','plan_type','category_id','subcategory_id'
    ];

    protected $casts = [
        'amount'    => 'double',
    ];

    public $translatable = ['title','description'];

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id','id')->withTrashed();
    }
    public function subcategory(){
        return $this->belongsTo('App\Models\SubCategory','subcategory_id','id')->withTrashed();
    }

    public function providers(){
        return $this->belongsTo('App\Models\User','provider_id','id')->withTrashed();
    }
}
