<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepresentationDetail extends Model
{
    use HasFactory,SoftDeletes;

    public function representation()
    {
        return $this->belongsTo(Representation::class);
    }
}
