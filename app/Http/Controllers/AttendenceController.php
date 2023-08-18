<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Http\Resources\Attendance\AttendanceResource;
use App\Models\Attendence;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendenceController extends Controller
{
    public function AddAttendence(Request $request)
    {
        $attendance = new Attendence();

        $attendance->staff_id = Auth::user()->id;
        $attendance->time = $request->time;
        $attendance->is_ending = false;

        $attendance->save();

        return response()->json([
            'message'=>'تم تسجيل الحضور وبداية الدوام',
            'attendance'=>new AttendanceResource($attendance),
        ]);
    }

    public function AddAttendanceEnd(Request $request)
    {
        $attendance = new Attendence();

        $attendance->staff_id = Auth::user()->id;
        $attendance->time = $request->time;
        $attendance->is_ending = true;

        $attendance->save();

        return response()->json([
            'message'=>'تم تسجيل نهاية الدوام',
            'attendance'=>new AttendanceResource($attendance),
        ]);
    }

    public function GetAttendanceReport(ReportRequest $request)
    {
        $attendances = Attendence::whereBetween('time',[$request->from_date,$request->to_date]);

        if($request->is_ending)
        {
            $attendances = $attendances->where('is_ending',$request->is_ending);
        }
        
        if($request->first_name)
        {
            $staff = Staff::where('first_name',$request->first_name)->get(['id']);
            $ids = [];
            foreach($staff as $member)
            {
                array_push($ids,$member->id);
            }
            $attendances = $attendances->whereIn('staff_id',$ids);
        }

        if($request->last_name)
        {
            $staff = Staff::where('last_name',$request->last_name)->get(['id']);
            $ids = [];
            foreach($staff as $member)
            {
                array_push($ids,$member->id);
            }
            $attendances = $attendances->whereIn('staff_id',$ids);
        }

        if($request->father_name)
        {
            $staff = Staff::where('father_name',$request->father_name)->get(['id']);
            $ids = [];
            foreach($staff as $member)
            {
                array_push($ids,$member->id);
            }
            $attendances = $attendances->whereIn('staff_id',$ids);
        }

        $attendances = $attendances->get();

        return AttendanceResource::collection($attendances);
    }

    public function GetStaffAttendance($id)
    {
        $attendances = Attendence::where('staff_id',$id)->get();

        return AttendanceResource::collection($attendances);
    }
    
}
