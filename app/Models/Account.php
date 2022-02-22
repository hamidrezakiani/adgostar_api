<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class Account extends Authenticatable
{
    use HasFactory,SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'phone',
        'password',
        'api_token'
    ];
    /**
     * The attributes that appends to array.
     *
     * @var array
     */
    protected $appends = ['isUser','isRepresentation','isExecuter','isAdmin'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password','remember_token'];
    protected static function boot(){
        parent::boot();
        static::creating(function ($model) {
            $model->api_token = Str::random(60);
        });
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function getIsAdminAttribute()
    {
        if($this->admin)
          return env('ADMIN_DOMAIN');
        return false;
    }

    public function getIsExecuterAttribute()
    {
        if($this->executer)
          return env('EXECUTER_DOMAIN');
        return false;
    }

    public function getIsRepresentationAttribute()
    {
        if($this->representation)
          return $this->representation->domain;
        else
          return false;
    }

    public function getIsUserAttribute()
    {
        if($this->user)
          return $this->user->representation->domain;
        else
          return false;
    }

    public function representation()
    {
        return $this->hasOne(Representation::class);
    }

    public function executer()
    {
        return $this->hasOne(Executer::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
}
