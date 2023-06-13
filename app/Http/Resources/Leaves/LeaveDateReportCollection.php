<?php

namespace App\Http\Resources\Leaves;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LeaveDateReportCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data'=>LeaveDateResource::collection($this->collection),
            'count'=>$this->count(),
        ];
    }
}
