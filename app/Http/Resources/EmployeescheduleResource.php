<?php

namespace App\Http\Resources;

use App\Http\Resources\Role\RoleResource;
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
            'id'=>$this->id,
            'days_of_week'=>$this->days_of_week,
            'start_time'=>$this->start_time,
            'end_time'=>$this->end_time,
            'main_role'=>$this->main_role,
            'role'=> new RoleResource($this->role),
        ];
    }
}
