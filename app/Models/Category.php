<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['parent_id','showParent_id','name','label','show','count_subCat', 'count_showSubCat', 'count_product'];
    // protected $appends = ['count_allProducts'];
    protected static function boot(){
        parent::boot();
        static::updating(function ($model) {
            if($model->parent_id)
            {

            $code = Category::find($model->parent_id)->code.':'.$model->parent_id;
            $model->code = $code;
            }
        });
    }

    public function scopeViewable($query)
    {
        return $query->where('show','YES');
    }

    public function scopeReadyService($query,$level = 10)
    {
       if($level > 0)
       {
            return $query->viewable()->whereHas('products', function ($subQuery) {
                return $subQuery->readyService();
            })->orWhere(function ($query) use ($level) {
                return $query->whereHas('showSubCats', function ($subQuery) use ($level) {
                    return $subQuery->readyService($level - 1);
                });
            });
       }
       else
       {
          return NULL;
       }
    }

    public function scopeReadyParticipation($query, $level = 10)
    {
        if ($level > 0) {
            return $query->viewable()->whereHas('products', function ($subQuery) {
                return $subQuery->viewable();
            })->orWhere(function ($query) use ($level) {
                return $query->whereHas('showSubCats', function ($subQuery) use ($level) {
                    return $subQuery->readyParticipation($level - 1);
                });
            });
        } else {
            return NULL;
        }
    }

    public function setShowParentIdAttribute($value){
        if($value == 0)
          $this->attributes['showParent_id'] = NULL;
        else
          $this->attributes['showParent_id'] = $value;
    }

    public function getCountAllProductsAttribute()
    {
        return $this->count_product + $this->countAllProductsOfCategoryArray($this->subCats);
    }

    public function countAllProducts($category)
    {
        if ($category->whereHas('showSubCats')->first()) {
            return $category->count_product
                + $this->countAllProductsOfCategoryArray($this->showSubCats);
        } else {
            return $category->count_product;
        }
    }

    public function countAllProductsOfCategoryArray($categories)
    {
       $count = 0;
       foreach($categories as $category)
       {
           $count += $this->countAllProducts($category);
       }
       return $count;
    }

    public function setParentIdAttribute($value){
        if($value == 0)
          $this->attributes['parent_id'] = NULL;
        else
          $this->attributes['parent_id'] = $value;
    }

    public function subCats()
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    public function showSubCats()
    {
        return $this->hasMany(Category::class,'showParent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function showParent()
    {
        return $this->belongsTo(Category::class,'showParent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
