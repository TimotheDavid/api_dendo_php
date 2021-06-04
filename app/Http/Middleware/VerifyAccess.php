<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifyAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        try{
            $token = explode(' ',$request->header('Authorization'))[1];

            $user = DB::table('users')
                ->where('token', $token)
                ->leftJoin('roles', 'users.role', '=', 'roles.id')
                ->get()[0];

            if(!$user){
                return response()->json(null, 401);
            }

            if($user->label !== $role){
                return response()->json(null, 401);
            }

            return $next($request);

        }catch (\Exception $error){
            return response()->json($error, 401);

        }
    }
}
