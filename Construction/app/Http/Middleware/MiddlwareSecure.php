<?php

namespace App\Http\Middleware;

use App\Models\Login;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MiddlwareSecure
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = session('user');
//        $userId = $user->getUserId();
//        $roles = $user->getRoles();
        $users = Login::where('nom',$user->nom)->first();
        if ($users->role!= 0) {
            abort(403,'Unauthorized');
        }
        return $next($request);
    }
}
