<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class developmentController extends Controller
{
    public function Test(Request $request)
    {

        $today = Carbon::now();
        $date = new Carbon($request->date);
        $list = [];

        while($today->toDateString() != $date->toDateString())
        {
            error_log("In Loop");
            error_log($today->toDateString());
            if($today->dayName != "Friday")
            {
                array_push($list,$today->dayName);
            }
            $today->addDay();
        }

        return response()->json([
            'today'=>$today->dayName,
            'date'=>$date->dayName,
            'list'=>$list,
            /*'yesterday'=>$yesterday->dayName,
            'before'=>$fri->dayName,*/
            'today_date'=>$today,
            'date_date'=>$date
        ]);
    }
}
