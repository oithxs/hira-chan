<?php

namespace App\Services\Tables;

use App\Exceptions\ThreadNotFoundException;
use App\Models\Hub;
use App\Repositories\HubRepository;

class HubService
{
    /**
     * 対応する書き込みを返却する
     *
     * @param string $threadId
     * @return Hub
     * @throws ThreadNotFoundException スレッドが存在しなかった場合
     */
    public function find(string $threadId): Hub
    {
        $thread = HubRepository::find($threadId);

        if ($thread !== null) {
            return $thread;
        } else {
            throw new ThreadNotFoundException();
        }
    }
}
