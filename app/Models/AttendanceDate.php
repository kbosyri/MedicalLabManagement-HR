<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceDate extends Model
{
    use HasFactory;

    public function staff()
    {
        return $this->belongsTo(Staff::class,'staff_id','id');
    }
}
