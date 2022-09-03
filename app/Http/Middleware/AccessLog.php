<?php

namespace App\Http\Middleware;

use App\Models\AccessLog as Log;
use Closure;
use Illuminate\Http\Request;
use RuntimeException;

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
        if (strpos($request->path(), config('admin.route.prefix')) === false) {
            try {
                Log::create([
                    'hub_id' => $request->thread_id ?? null,
                    'session_id' => $request->session()->getId(),
                    'user_id' => $request->user()->id ?? null,
                    'uri' => $request->path(),
                ]);
            } catch (RuntimeException) {
                /*
                RuntimeException: Session store not set on request.

                Do nothing when an exception occurs because the session can be retrieved.
                */
            }
        }

        return $response;
    }
}