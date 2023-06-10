<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employeeschedule extends Model
{
    use HasFactory;
  
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }


    public function getWorkingDaysAttribute()
    {
        $workingDays = [];

        if ($this->role == 'is_admin') {
            $workingDays = ['Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday','Saturday'];
        } elseif ($this->role == 'is_lab_staff') {
            $workingDays = ['Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday',  'Saturday'];
        } elseif ($this->role == 'is_reception') {
            $workingDays = ['Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday',  'Saturday'];
        }

        
        $daysAvailable = explode(',', $this->days_available);
        foreach ($daysAvailable as $day) {
            if (in_array($day, $workingDays)) {
                array_push($workingDays, $day);
            }
        }

        return $workingDays;
    }


    public function getWorkingHoursAttribute()
    {
        $workingHours = [];

       
        if ($this->start_time && $this->end_time) {
            $workingHours = [
                'start_time' => $this->start_time,
                'end_time' => $this->end_time
            ];
        }

        return $workingHours;
    }
  
}
  

