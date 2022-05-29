<?php

namespace App\Models;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['product_id','name','turkish_name','alias','turkish_alias','viewable','tab_index'];
    
    protected static function boot(){
        parent::boot();
        static::creating(function($model){
          $last_brother = Item::where('product_id',$model->product_id)->orderBy('tab_index','DESC')->first();
          $model->tab_index = 1 + ($last_brother?$last_brother->tab_index:-1);
        });
    }
    
    public function scopeViewable($query)
    {
        return $query->where('viewable','YES');
    }

    public function scopeReadyService($query)
    {
        return $query->viewable()->whereHas('participation')->whereHas('periods');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function participation()
    {
        return $this->hasOne(Participation::class);
    }

    public function periods()
    {
        return $this->hasMany(ItemPeriod::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
