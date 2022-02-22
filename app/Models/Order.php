<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id','representation_id','user_id','executer_id',
        'product_name','item_name','unit_price','count',
        'amount','wallet_payment','bank_payment','status',
        'startTime','endTime','time_status'
    ];

    public function payment()
    {
        return $this->hasMany(Payment::class,'id','property_id');
    }

    public function times()
    {
        return $this->hasMany(OrderTime::class);
    }

    public function properties()
    {
        return $this->hasMany(OrderProperty::class);
    }

    public function transactions()
    {
        return $this->hasMany(OrderTransaction::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function representation()
    {
        return $this->belongsTo(Representation::class);
    }

    public function executer()
    {
        return $this->belongsTo(Executer::class);
    }

    public function representationTransactions()
    {
        return $this->hasMany(RepresentationTransaction::class,'property_id');
    }

    public function executerTransaction()
    {
        return $this->hasOne(ExecuterTransaction::class,'property_id');
    }
}
