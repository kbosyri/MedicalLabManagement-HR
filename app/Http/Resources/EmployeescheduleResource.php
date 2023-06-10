<?php

namespace App\Http\Resources;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeescheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'staff_id'=> new Staff($this->Staff),
            'day_of_week'=>$this->day_of_week,
            'role'=>$this->role,
            'start_time'=>$this->start_time,
            'end_time'=>$this->end_time
            

        ];
    }
}
