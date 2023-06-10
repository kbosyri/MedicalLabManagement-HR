<?php

namespace App\Http\Resources;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveResource extends JsonResource
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
            'leavetype'=>$this->leavetype,
            'start_time'=>$this->start_time,
            'end_time'=>$this->end_time,
            'duration'=>$this->duration
            

        ];
    }
}
