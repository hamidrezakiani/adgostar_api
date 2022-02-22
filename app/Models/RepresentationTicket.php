<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepresentationTicket extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['representation_id','title','priority','status','created_by'];
    public function representation()
    {
        return $this->belongsTo(Representation::class);
    }

    public function messages()
    {
        return $this->hasMany(RepresentationTicketMessage::class);
    }
}
