<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemPeriod extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['item_id','start','end','time'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function representationItemPeriod()
    {
        return $this->hasMany(RepresentationItemPeriod::class);
    }
}
