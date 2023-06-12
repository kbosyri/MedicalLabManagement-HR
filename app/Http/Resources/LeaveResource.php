<?php

namespace App\Http\Resources;

use App\Http\Resources\Role\RoleStaffResource;
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
            'start_time'=>$this->start_time,
            'duration'=>$this->duration,
            'is_paid'=>$this->is_paid,
            'is_accepted'=>$this->is_accepted,
            'staff_id'=> new RoleStaffResource($this->staff),
        ];
    }
}
