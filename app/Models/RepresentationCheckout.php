<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepresentationCheckout extends Model
{
    use HasFactory;
    protected $fillable = ['representation_id', 'amount', 'status'];

    public function representation()
    {
        return $this->belongsTo(Representation::class);
    }

    public function representationTransaction()
    {
        return $this->hasOne(RepresentationTransaction::class,'property_id');
    }
}
