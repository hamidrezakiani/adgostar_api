<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParticipationPeriod extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['participation_id','start','end','cost'];

    public function participation()
    {
        return $this->belongsTo(Participation::class);
    }
}
