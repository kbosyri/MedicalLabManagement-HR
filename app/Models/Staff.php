<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table='Staffs';


    public function schedule()
    {
return $this->hasMany(Employeeschedule::class);
    }


    public function leave()
    {
return $this->hasMany(Leave::class);
    }
}
