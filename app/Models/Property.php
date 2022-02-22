<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['product_id','property_type_id','label','size','placeholder','tooltip','required'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderProperties()
    {
        return $this->hasMany(OrderProperty::class);
    }

    public function type()
    {
        return $this->belongsTo(PropertyType::class,'property_type_id','id');
    }
}
