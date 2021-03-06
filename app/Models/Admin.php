<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Admin extends Authenticatable
{
    use HasFactory,SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone',
        'password',
        'firstName',
        'lastName',
        'avatar',
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

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
    
    public function executer()
    {
        return $this->belongsTo(Executer::class,'phone','phone');
    }
    
    public function agent()
    {
        return $this->belongsTo(Representation::class,'phone','phone');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class,'phone','phone');
    }
}
