<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'representation_id',
        'phone',
        'password',
        'firstName',
        'lastName',
        'avatar',
        'wallet',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $appends = ['agent'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->api_token = Str::random(60);
        });
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'phone','phone');
    }

    public function executer()
    {
        return $this->belongsTo(Executer::class,'phone','phone');
    }

    public function getAgentAttribute()
    {
        return $this->role == 'OWNER';
    }

    public function representation()
    {
        return $this->belongsTo(Representation::class);
    }

    public function tickets()
    {
        return $this->hasMany(UserTicket::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
