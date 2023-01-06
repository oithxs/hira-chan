<?php

namespace App\Http\Controllers\ThreadBrowsingHistory;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use Illuminate\Http\Request;

class ThreadBrowsingHistoryController extends Controller
{
    /**
     * 重複なしで，過去に閲覧したスレッドを取得する
     *
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        $history = AccessLog::with('hub')
            ->where('user_id', '=', $request->user()->id)
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('access_logs')
                    ->groupBy('hub_id');
            })
            ->orderByDesc('id')
            ->get();

        return view('thread-browsing-history.show', [
            'history' => $history,
        ]);
    }
}
