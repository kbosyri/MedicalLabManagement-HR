<?php

namespace App\Http\Resources\Attendance;

use App\Http\Resources\Role\RoleStaffResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'time'=>$this->time,
            'is_ending'=>$this->is_ending,
            'staff'=>new RoleStaffResource($this->staff),
        ];
    }
}
