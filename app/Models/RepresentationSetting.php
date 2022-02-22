<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepresentationSetting extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'representation_id',
        'seniorRepresentationProfit',
        'normalRepresentationProfit',
        'userProfit'
    ];

    public function representation()
    {
        return $this->belongsTo(Representation::class);
    }
}
