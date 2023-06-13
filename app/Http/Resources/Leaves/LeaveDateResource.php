<?php

namespace App\Http\Resources\Leaves;

use App\Http\Resources\Role\RoleStaffResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveDateResource extends JsonResource
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
            'date'=>$this->date,
            'is_paid'=>$this->is_paid,
            'staff'=> new RoleStaffResource($this->staff),
        ];
    }
}
