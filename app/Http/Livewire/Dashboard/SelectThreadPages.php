<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SelectThreadPages extends Component
{
    public function render(Request $request)
    {
        if ($request->category == NULL) {
            $RecordNum = DB::connection('mysql_keiziban')
                ->table('hub')
                ->count();
        } else {
            $RecordNum = DB::connection('mysql_keiziban')
                ->table('hub')
                ->where('thread_category', '=', $request->category)
                ->count();
        }
        return view('dashboard.select-thread-pages', [
            'max_thread' => $RecordNum,
            'sort' => $request->sort,
            'category' => $request->category
        ]);
    }
}
