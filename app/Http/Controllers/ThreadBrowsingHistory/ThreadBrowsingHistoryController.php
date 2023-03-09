<?php

namespace App\Http\Controllers\ThreadBrowsingHistory;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ThreadBrowsingHistoryController extends Controller
{
    /**
     * 閲覧履歴ページを表示する
     *
     * @param Request $request
     * @return View
     */
    public function __invoke(Request $request): View
    {
        return view('thread-browsing-history.show', [
            'history' => $this->getHistory($request->user()->id),
        ]);
    }

    /**
     * 重複なしで，過去に閲覧したスレッドを取得する
     *
     * @param string $user_id
     * @return Collection
     */
    private function getHistory(string $user_id): Collection
    {
        return  AccessLog::with('hub')
            ->where('user_id', '=', $user_id)
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('access_logs')
                    ->groupBy('hub_id');
            })
            ->orderByDesc('id')
            ->get();
    }
}
