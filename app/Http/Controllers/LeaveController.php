<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeaveResource;
use App\Models\Leave;
use App\Models\Staff;
use Illuminate\Http\Request;

class LeaveController extends Controller
{

    public function index(Staff $staff)
    {
        return response()->json(['leave' => $staff->leaves]);
    }

    public function show(Staff $staff, $leaveId)
    {
        $leave = $staff->leaves()->findOrFail($leaveId);

        return response()->json(['leave' => $leave]);
    }


    public function create_leave(Request $request)
    {
        $leave=new Leave();
        $leave->staff_id=$request->staff_id;
        $leave->leavetype=$request->leavetype;
        $leave->start_date=$request->start_date;
        $leave->end_date=$request->end_date;
        $leave->duration=$this->calculateDuration($request->start_date, $request->end_date);
        $leave->save();
        return response()->json([
            'message' => 'تم انشأ الإجازة  بنجاح',
            'leave' => new LeaveResource($leave),
        ]);
    }

    public function update_leave(Request $request,$id)
    {
        $leave= Leave ::find($id);
        $leave->staff_id=$request->staff_id;
        $leave->leavetype=$request->leavetype;
        $leave->start_date=$request->start_date;
        $leave->end_date=$request->end_date;
        $leave->duration=$this->calculateDuration($request->start_date, $request->end_date);
        $leave->save();
        return response()->json([
            'message' => 'تم تعديل الإجازة  بنجاح',
            'leave' => new LeaveResource($leave),
        ]);
    }


    protected function calculateDuration($startDate, $endDate)
    {
        $start = strtotime($startDate);
        $end = strtotime($endDate);

        $days = ($end - $start) / (60 * 60 * 24);

        return $days + 1; 
    }
}
