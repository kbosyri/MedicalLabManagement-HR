<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Employeeschedule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->role)
        {
            if(!Auth::user()->role->human_resources)
            {
                return response()->json(['message'=>'المستخدم غير مسموح له باستخدام هذا الرابط'],403);
            }
        }
        if(!Auth::user()->is_admin)
        {
            return response()->json(['message'=>'المستخدم غير مسموح له باستخدام هذا الرابط'],403);
        }
        return $next($request);
    }
}

