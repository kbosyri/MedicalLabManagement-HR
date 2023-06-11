<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Authenticatable
{
    use HasFactory,Notifiable,HasApiTokens;
    protected $table='Staff';


    public function schedule()
    {
        return $this->hasMany(Employeeschedule::class);
    }


    public function leave()
    {
        return $this->hasMany(Leave::class);
    }
}
