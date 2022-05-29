<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['category_id','name','turkish_name','label','turkish_label','viewable','count_item','count_property','tab_index'];
    
    protected static function boot(){
        parent::boot();
        static::creating(function($model){
          $last_brother = Product::where('category_id',$model->category_id)->orderBy('tab_index','DESC')->first();
          $model->tab_index = 1 + ($last_brother?$last_brother->tab_index:-1);
        });
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeViewable($query)
    {
        return $query->where('viewable','YES');
    }

    public function scopeReadyService($query)
    {
        return $query->whereHas('participations', function ($subQuery) {
                return $subQuery->whereHas('item', function ($subQuery) {
                    return $subQuery->viewable();
                });
               })->viewable();
    }

    public function executerParticipation($executer_id)
    {
       return $this->participations()->where('executer_id',$executer_id)->first();
    }

    public function items()
    {
        return $this->hasMany(Item::class)->orderBy('tab_index','ASC');
    }

    public function Properties()
    {
        return $this->hasMany(Property::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }
}
