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
        if($this->is_reception)
        {
            return Employeeschedule::where("main_role","reception")->first();
        }
        else if($this->is_lab_staff)
        {
            return Employeeschedule::where("main_role","lab staff")->first();
        }
        return Employeeschedule::where('role_id',$this->role_id)->first();
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
