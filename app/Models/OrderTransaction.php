<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','representation_id','amount','status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function representation()
    {
        return $this->belongsTo(Representation::class);
    }
}
