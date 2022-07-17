<?php

namespace App\Http\Middleware;

use App\Models\Crew;
use Closure;
use Illuminate\Http\Request;

class Authenticate 
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @param  string|null  $field
     * @return mixed
     *
     */
    public function handle(Request $request, Closure $next, $guard = null, $field = null)
    {
        $token = $request->bearerToken();
        $crew = Crew::where('api_token', $token)->first();
        if(!$crew) {
            abort(401);
        }
        
        $request->attributes->add(['crewMember' => $crew]);
        return $next($request);
    }
}
