<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTicket extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['user_id','title','priority','status','created_by'];

    public function messages()
    {
        return $this->hasMany(UserTicketMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
