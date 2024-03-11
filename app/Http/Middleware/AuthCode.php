<?php

namespace App\Http\Middleware;

use App\Mail\LoginCode;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class AuthCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        $email = $request->only('email');
        $query = User::where('email',$email)->first();
        if($query && $query->code == null){
            return $next($request);
        }
       
        response()->json('Se mando tu codigo a tu correo',403);
        
       

        
    }
}
