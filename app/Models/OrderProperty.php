<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProperty extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['order_id','property_id','value'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
