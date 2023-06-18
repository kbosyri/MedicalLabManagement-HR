<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeescheduleRequest;
use App\Http\Resources\EmployeescheduleResource;
use App\Models\Staff;
use App\Models\Employeeschedule;
use App\Models\Role;
use Illuminate\Http\Request;

class EmployeescheduleController extends Controller
{
    public function show_all()
    {
        $staff = Employeeschedule::all();
        if ($staff->count() > 0) {
            return EmployeescheduleResource::collection($staff);
        } else {
            return  response()->json([
                'message' => ' لايوجد موظفين ',
            ],500);
        }
    }

    public function create_empschedual(EmployeescheduleRequest $request)
    {
        $empschedule=new Employeeschedule();
        $role = Role::find($request->role_id);

        if($request->role_id)
        {
            $empschedule->role_id=$request->role_id;
            $empschedule->main_role = $role->name;
        }
        else
        {
            $empschedule->main_role = $request->main_role;
        }

        $empschedule->days_of_week=$request->days_of_week;
        $empschedule->start_time=$request->start_time;
        $empschedule->end_time=$request->end_time;

        $empschedule->save();

        return response()->json([
            'message' => 'تم انشأ الجدول الزمني  بنجاح',
            'schedule' => new EmployeescheduleResource($empschedule),
        ]);

    }

    public function update_empschedual(EmployeescheduleRequest $request,$id)
    {
        $empschedule= Employeeschedule::find($id);

        $empschedule->role_id=$request->role_id;
        $empschedule->main_role = $request->main_role;
        $empschedule->days_of_week=$request->days_of_week;
        $empschedule->start_time=$request->start_time;
        $empschedule->end_time=$request->end_time;

        $empschedule->save();

        return response()->json([
            'message' => 'تم تعديل الجدول الزمني  بنجاح',
            'empschedule' => new EmployeescheduleResource($empschedule),
        ]);

    }

    public function GetSchedule($id)
    {
        $schedule = Employeeschedule::find($id);

        return new EmployeescheduleResource($schedule);
    }

    public function GetSchedules()
    {
        $schedules = Employeeschedule::all();

        return EmployeescheduleResource::collection($schedules);
    }
}
