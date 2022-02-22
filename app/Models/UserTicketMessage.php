<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTicketMessage extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['representation_id','text'];

    public function ticket()
    {
        return $this->belongsTo(UserTicket::class);
    }

    public function representation()
    {
        return $this->belongsTo(Representation::class);
    }
}
