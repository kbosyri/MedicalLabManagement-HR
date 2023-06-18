<?php

use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\EmployeescheduleController;
use App\Http\Controllers\GrantsController;
use App\Http\Controllers\LeaveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function(){
    Route::middleware('check-admin')->group(function(){
        Route::get('/schedules',[EmployeescheduleController::class,'show_all']);
        Route::get('/schedules/{id}',[EmployeescheduleController::class,'GetSchedule']);
    });
    Route::post('/schedules',[EmployeescheduleController::class,'create_empschedual']);
    Route::post('/schedules/{id}',[EmployeescheduleController::class,'update_empschedual']);
});

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/staff/{id}/leaves',[LeaveController::class,'index']);
    Route::get('/user/leaves/requests',[LeaveController::class,'GetUserLeaveRequests']);
    Route::middleware('check-admin')->get('/leaves/requests/',[LeaveController::class,'GetLeaveRequests']);
    Route::middleware('check-admin')->get('/leaves/reports',[LeaveController::class,'LeaveReport']);
    Route::get('/leaves/requests/{id}',[LeaveController::class,'GetLeaveRequest']);
    Route::post('/leaves/requests',[LeaveController::class,'create_leave_request']);
    Route::middleware('transaction')->post('/leaves/requests/{id}/decision',[LeaveController::class,'SendLeaveDecision']);
    Route::post('/leaves/requests/{id}',[LeaveController::class,'update_leave_request']);
});

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/grants',[GrantsController::class,'AddGrant']);

    Route::middleware('check-admin')->group(function(){
        Route::delete('/grants/{id}',[GrantsController::class,'DeleteGrant']);
        Route::get('/grants',[GrantsController::class,'GetGrants']);
        Route::get('/grants/report',[GrantsController::class,'GetGrantsInDates']);
        Route::get('/grants/{id}',[GrantsController::class,'GetGrant']);
    });
});

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/attendances/start',[AttendenceController::class,'AddAttendence']);
    Route::post('/attendances/end',[AttendenceController::class,'AddAttendanceEnd']);

    Route::get('/attendances/report',[AttendenceController::class,'GetAttendanceReport']);
    Route::get('/staff/{id}/attendances',[AttendenceController::class,'GetStaffAttendance']);
});



