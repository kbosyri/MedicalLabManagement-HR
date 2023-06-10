<?php

namespace App\Http\Resources\Role;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleStaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'biometric_id'=>$this->biometric_id,
            'first_name'=>$this->first_name,
            'father_name'=>$this->father_name,
            'last_name'=>$this->last_name,
            'username'=>$this->username,
            'qualifications'=>$this->qualifications,
            'email'=>$this->email,
            'phone'=>$this->phone,
        ];
    }
}
