<?php

namespace App\Http\Controllers;

use App\Http\Requests\Grants\GrantsRequest;
use App\Http\Resources\Grants\GrantResource;
use App\Models\Grant;
use Illuminate\Http\Request;

class GrantsController extends Controller
{
    public function AddGrant(GrantsRequest $request)
    {
        $grant = new Grant();

        $grant->name = $request->name;
        $grant->amount = $request->amount;

        $grant->save();

        return response()->json([
            'message'=>'تم إضافة المنحة',
            'grant'=>new GrantResource($grant)
        ]);
    }

    public function DeleteGrant($id)
    {
        $grant = Grant::find($id);

        $grant->delete();

        return response()->json([
            'message'=>'تم حذف المنحة'
        ]);
    }

    public function GetGrants()
    {
        $grants = Grant::all();

        return GrantResource::collection($grants);
    }

    public function GetGrant($id)
    {
        $grant = Grant::find($id);

        return new GrantResource($grant);
    }

    public function GetGrantsInDates(Request $request)
    {
        $grants = Grant::whereBetween('created_at',[$request->from_date,$request->to_date])->get();

        return GrantResource::collection($grants);
    }
}
