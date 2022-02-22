<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExecuterTransaction extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['executer_id','amount', 'type', 'property', 'property_id',
        'status','balance','removable'];


    public function propertyEloquent()
    {
        switch ($this->property) {
            case 'CHECKOUT':
                return $this->belongsTo(ExecuterCheckout::class,'property_id');
                break;
            case 'ORDER':
                return $this->belongsTo(Order::class,'property_id');
                break;
            default:
                # code...
                break;
        }
    }

    public function executer()
    {
        return $this->belongsTo(Executer::class);
    }
}
