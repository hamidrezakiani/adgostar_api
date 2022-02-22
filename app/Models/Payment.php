<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'propertyType','property_id','host','ip','amount','status',
        'bank','status_code','payment_id','card_number',
        'hashed_card_number','date','track_id',
    ];

    public function property()
    {
        switch($this->propertyType)
        {
            case 'ORDER':
                return $this->belongsTo(Order::class,'property_id');
                break;
            case 'WALLET':

                break;
            case 'PANEL':

                break;
            default :
                break;
        }
    }
}
