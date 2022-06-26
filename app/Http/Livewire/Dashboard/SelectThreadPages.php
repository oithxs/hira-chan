<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SelectThreadPages extends Component
{
    public function render(Request $request)
    {
        $RecordNum = DB::connection('mysql_keiziban')->table('hub')->count();
        return view('dashboard.select-thread-pages', [
            'max_thread' => $RecordNum,
            'sort' => $request->sort
        ]);
    }
}
