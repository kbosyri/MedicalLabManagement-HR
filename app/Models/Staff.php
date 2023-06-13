<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use HasFactory,Notifiable,HasApiTokens;
    protected $table='Staff';


    public function schedule()
    {
        return $this->hasMany(Employeeschedule::class);
    }


    public function leaves()
    {
        return $this->hasMany(LeaveDate::class);
    }

    public function leave_requests()
    {
        return $this->hasMany(Leave::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class,'role_id','id');
    }
}
