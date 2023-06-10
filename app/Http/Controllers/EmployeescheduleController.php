<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeescheduleResource;
use App\Models\Staff;
use App\Models\Employeeschedule;
use Illuminate\Http\Request;

class EmployeescheduleController extends Controller
{
    public function show_all()
    {
        $staff = Staff::all();
        if ($staff->count() > 0) {
            return EmployeescheduleResource::collection($staff);
        } else {
            return  response()->json([
                'message' => ' لايوجد موظفين ',
                '' => new EmployeescheduleResource($staff)
            ],);
        }
    }

    public function create_empschedual(Request $request)
{
    $empschedule=new Employeeschedule();
    $empschedule->staff_id=$request->staff_id;
    $empschedule->day_of_week=$request->day_of_week;
    $empschedule->role=$request->role;
    $empschedule->start_time=$request->start_time;
    $empschedule->end_time=$request->end_time;
    $empschedule->save();
    return response()->json([
        'message' => 'تم انشأ الجدول الزمني  بنجاح',
        'empschedule' => new EmployeescheduleResource($empschedule),
    ]);

}
public function update_empschedual(Request $request,$id)
{
    $empschedule= Employeeschedule::find($id);
    $empschedule->staff_id=$request->staff_id;
    $empschedule->day_of_week=$request->day_of_week;
    $empschedule->role=$request->role;
    $empschedule->start_time=$request->start_time;
    $empschedule->end_time=$request->end_time;
    $empschedule->save();
    return response()->json([
        'message' => 'تم تعديل الجدول الزمني  بنجاح',
        'empschedule' => new EmployeescheduleResource($empschedule),
    ]);

}

    
}
