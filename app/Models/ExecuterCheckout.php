<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExecuterCheckout extends Model
{
    use HasFactory;
    protected $fillable = ['executer_id', 'amount', 'status'];

    public function executer()
    {
        return $this->belongsTo(Executer::class);
    }

    public function executerTransaction()
    {
        return $this->hasOne(ExecuterTransaction::class,'property_id');
    }
}
