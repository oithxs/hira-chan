<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Record_AccessLog;

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
        $thread_name = $request->thread_name;
        $thread_id = $request->thread_id;
        $user_email = $request->user()->email;
        $ip = $request->ip();
        $save = new Record_AccessLog;
        $save->func(
            $thread_name,
            $thread_id,
            $user_email,
            $ip
        );
        return $next($request);
    }
}
