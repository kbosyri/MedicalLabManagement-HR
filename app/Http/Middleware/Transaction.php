<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class Transaction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = '';
        DB::beginTransaction();
        try
        {
            $response = $next($request);
            DB::commit();
            
        }catch(Exception $e)
        {
            DB::rollBack();
            return $e;
        }
        return $response;
    }
}
