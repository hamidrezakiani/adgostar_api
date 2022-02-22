<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Representation extends Authenticatable
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['api_token'];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function parent()
    {
        return $this->belongsTo(Representation::class,'parent_id');
    }

    public function setting()
    {
        return $this->hasOne(RepresentationSetting::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function detail()
    {
        return $this->hasOne(RepresentationDetail::class);
    }

    public function userTickets()
    {
        return $this->hasMany(UserTicket::class);
    }

    public function tickets()
    {
        return $this->hasMany(RepresentationTicket::class);
    }

    public function periods()
    {
        return $this->hasMany(RepresentationItemPeriod::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function transactions()
    {
        return $this->hasMany(OrderTransaction::class);
    }
}

