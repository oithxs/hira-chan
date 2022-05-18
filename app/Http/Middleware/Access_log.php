<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Get_AccessLog;

class Access_log
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
        $table = $request->thread_id;
        $user = $request->user()->id;
        $ip = $request->ip();
        $save = new Get_AccessLog;
        $save->func(
            $table,
            $user,
            $ip
        );
        return $next($request);
    }
}
