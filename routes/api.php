<?php

use App\Http\Controllers\EmployeescheduleController;
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
    Route::get('/show_all',[EmployeescheduleController::class,'show_all']);
    Route::post('/create_empschedual',[EmployeescheduleController::class,'create_empschedual']);
    Route::post('/update_empschedual/{id}',[EmployeescheduleController::class,'update_empschedual']);
    });

    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/index',[LeaveController::class,'index']);
        Route::get('/show /{id}',[LeaveController::class,'show']);
        Route::post('/create_leave',[LeaveController::class,'create_leave']);
        Route::post('/update_leave/{id}',[LeaveController::class,'update_leave']);
        });


