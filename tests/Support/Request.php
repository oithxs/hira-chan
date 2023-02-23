<?php

namespace Tests\Support;

use App\Models\User;
use Illuminate\Http\Request as HttpRequest;

class Request
{
    /**
     * Requestのインスタンスを作成する
     *
     * @param array $query $request->で取得可能にする要素
     * @param User|null $user $request->user()で取得可能にするユーザ
     * @return HttpRequest Illuminate\Http\Requestのインスタンス
     */
    public function make(array $query = [], User $user = null, string $httpRequest = HttpRequest::class): HttpRequest
    {
        $request = new $httpRequest($query);
        $user === null ?: $request->setUserResolver(function () use ($user) {
            return $user;
        });
        return $request;
    }
}
