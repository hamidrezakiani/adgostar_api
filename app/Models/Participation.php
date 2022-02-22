<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participation extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['executer_id','product_id','item_id'];

    public function executer()
    {
        return $this->belongsTo(Executer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function periods()
    {
        return $this->hasMany(ParticipationPeriod::class);
    }
}
