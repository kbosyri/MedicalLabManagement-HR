<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveDecisionRequest;
use App\Http\Requests\LeaveRequest;
use App\Http\Resources\LeaveResource;
use App\Http\Resources\Leaves\LeaveDateReportCollection;
use App\Http\Resources\Leaves\LeaveDateResource;
use App\Models\Leave;
use App\Models\LeaveDate;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{

    public function index($staff_id)
    {
        $staff = Staff::find($staff_id);

        return LeaveResource::collection($staff->leave_requests);
    }

    public function show(Staff $staff, $leaveId)
    {
        $leave = $staff->leaves()->findOrFail($leaveId);

        return response()->json(['leave' => $leave]);
    }

    public function GetUserLeaveRequests()
    {
        return LeaveResource::collection(Auth::user()->leave_requests);
    }

    public function GetLeaveRequests()
    {
        $leaves = Leave::where("is_accepted",null)->get();

        return LeaveResource::collection($leaves);
    }

    public function GetLeaveRequest($id)
    {
        $leave = Leave::find($id);

        return new LeaveResource($leave);
    }

    public function create_leave_request(LeaveRequest $request)
    {
        $leave=new Leave();

        $leave->staff_id=Auth::user()->id;
        $leave->is_paid=$request->is_paid;
        $leave->start_date=$request->start_date;
        $leave->duration=$request->duration;

        $leave->save();

        return response()->json([
            'message' => 'تم انشاء طلب الإجازة  بنجاح',
            'leave' => new LeaveResource($leave),
        ]);
    }

    public function update_leave_request(LeaveRequest $request,$id)
    {
        $leave= Leave ::find($id);

        if(Auth::user()->id != $leave->staff_id)
        {
            return response()->json([
                'message'=>'هذا المستخدم غير مسموح له بتعديل هذا الطلب'
            ],400);
        }

        $leave->is_paid=$request->is_paid;
        $leave->start_date=$request->start_date;
        $leave->duration=$request->duration;

        $leave->save();

        return response()->json([
            'message' => 'تم تعديل طلب الإجازة  بنجاح',
            'leave' => new LeaveResource($leave),
        ]);
    }

    public function SendLeaveDecision(LeaveDecisionRequest $request,$id)
    {
        $leave = Leave::find($id);

        $leave->is_accepted = $request->decision;

        $leave->save();

        if($leave->is_accepted)
        {
            $date = new Carbon($leave->start_date);
            $i = 0;
            while($i < $leave->duration)
            {
                if($date->dayName == "Friday")
                {
                    $date->addDay();
                    continue;
                }
                $leavedate = new LeaveDate();

                $leavedate->staff_id = $leave->staff_id;
                $leavedate->date = $date;
                $leavedate->is_paid = $leave->is_paid;

                $leavedate->save();

                $date->addDay();
                $i++;
            }
        }

        return response()->json([
            'message'=>'تم تسجيل القرار لطلب العطلة',
            'leave_request'=>new LeaveResource($leave),
        ]);
    }

    public function LeaveReport(Request $request)
    {
        $leaves = LeaveDate::whereBetween('date',[$request->from_date,$request->to_date]);

        if($request->first_name)
        {
            $staff = Staff::where('first_name',$request->first_name)->get(['id']);
            $ids = [];
            foreach($staff as $member)
            {
                array_push($ids,$member->id);
            }
            $leaves = $leaves->whereIn('staff_id',$ids);
        }
        if($request->last_name)
        {
            $staff = Staff::where('last_name',$request->last_name)->get(['id']);
            $ids = [];
            foreach($staff as $member)
            {
                array_push($ids,$member->id);
            }
            $leaves = $leaves->whereIn('staff_id',$ids);
        }
        if($request->father_name)
        {
            $staff = Staff::where('father_name',$request->father_name)->get(['id']);
            $ids = [];
            foreach($staff as $member)
            {
                array_push($ids,$member->id);
            }
            $leaves = $leaves->whereIn('staff_id',$ids);
        }
        if($request->is_paid != null)
        {
            $leaves = $leaves->where('is_paid',$request->is_paid);
        }

        $leaves = $leaves->get();
        
        return new LeaveDateReportCollection($leaves);
    }


    protected function calculateDuration($startDate, $endDate)
    {
        $start = strtotime($startDate);
        $end = strtotime($endDate);

        $days = ($end - $start) / (60 * 60 * 24);

        return $days + 1; 
    }
}
