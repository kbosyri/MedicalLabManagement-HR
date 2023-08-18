<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class EmployeescheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        if(Auth::user()->role)
        {
            if(Auth::user()->role->human_resources)
            {
                return true;
            }
        }
        return Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        $days = "Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday";
        return [
            'role_id'=>['present'],
            'main_role'=>['present'],
            'days_of_week'=>['required','array','in:'.$days,],
            'start_time'=>['required'],
            'end_time'=>['required']
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'=>false,
            'message'=>'يوجد خطأ في القيم المدخلة',
            'errors'=>$validator->errors()
        ],400));
    }
}
