<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['category_id','name','viewable','count_item','count_property'];

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
        return $this->hasMany(Item::class);
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
