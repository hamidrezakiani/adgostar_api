<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepresentationItemPeriod extends Model
{
    use HasFactory,SoftDeletes;

    public function scopeOld($query)
    {
      return $query->whereDoesntHave('itemPeriod');
    }

    protected $fillable = [
        'representation_id',
        'item_period_id',
        'seniorRepresentationProfit',
        'normalRepresentationProfit',
        'userProfit'
    ];

    public function representation()
    {
        return $this->belongsTo(Representation::class);
    }

    public function itemPeriod()
    {
        return $this->belongsTo(ItemPeriod::class);
    }
}
