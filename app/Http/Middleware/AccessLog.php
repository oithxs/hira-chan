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

        if (strcmp(url()->current(), route('thread.get')) !== 0) {
            $thread_id = $request->thread_id;
            if (strpos($request->path(), 'jQuery.ajax') === 0) {
                $thread_id = null;
            }

            try {
                Log::create([
                    'hub_id' => $thread_id,
                    'session_id' => $request->session()->getId(),
                    'user_id' => $request->user()->id ?? null,
                    'uri' => $request->path(),
                ]);
            } catch (RuntimeException) {
                /*
                RuntimeException: Session store not set on request.

                実際にはSessionの取得が出来ているため，例外が発生した場合は何もしない
                */
            }
        }

        return $response;
    }
}
