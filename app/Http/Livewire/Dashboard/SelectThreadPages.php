<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SelectThreadPages extends Component
{
    public function render()
    {
        $RecordNum = DB::connection('mysql_keiziban')->table('hub')->count();
        return view('dashboard.select-thread-pages', [
            'max_thread' => $RecordNum
        ]);
    }
}
