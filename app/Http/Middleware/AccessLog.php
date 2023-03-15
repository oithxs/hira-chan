<?php

namespace App\Http\Middleware;

use App\Models\AccessLog as Log;
use App\Models\Hub;
use Closure;
use Illuminate\Http\Request;
use RuntimeException;

class AccessLog
{
    /**
     * ユーザがアクセスした全ての履歴を保存する．
     * このミドルウェアは全てのアクセスに対して実行される．
     *
     *  例外)
     *  - 書き込みの取得
     *
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     * @todo https://github.com/oithxs/hira-chan/issues/205
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (Hub::where('id', '=', $request->thread_id)->first()->id ?? "No data" === $request->thread_id) {
            if (session()->get('thread_id') !== $request->thread_id) {
                Log::create([
                    'hub_id' => $request->thread_id,
                    'user_id' => $request->user()->id ?? null,
                ]);
                session()->put('thread_id', $request->thread_id);
            }
        }

        return $response;
    }
}
