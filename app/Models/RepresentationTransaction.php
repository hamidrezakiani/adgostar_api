<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepresentationTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['representation_id','amount','type',
    'property','property_id','status','balance','removable'];

    public function representation()
    {
        return $this->belongsTo(Representation::class);
    }

    public function propertyEloquent()
    {
        switch ($this->property) {
            case 'CHECKOUT':
                return $this->belongsTo(ExecuterCheckout::class,'property_id');
                break;
            case 'ORDER':
                return $this->belongsTo(Order::class,'property_id');
                break;
            case 'SUBSET_ORDER':
                return $this->belongsTo(Order::class,'property_id');
                break;
            default:
                # code...
                break;
        }
    }
}
