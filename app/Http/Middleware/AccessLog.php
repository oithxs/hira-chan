<?php

namespace App\Http\Middleware;

use App\Models\AccessLog as Log;
use App\Models\Session;
use Closure;
use Illuminate\Http\Request;

class AccessLog
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
        $response = $next($request);

        Log::create([
            'hub_id' => $request->thread_id ?? null,
            'session_id' => $request->session()->getId(),
            'user_id' => $request->user()->id ?? null,
            'uri' => $request->path(),
        ]);

        return $response;
    }
}
