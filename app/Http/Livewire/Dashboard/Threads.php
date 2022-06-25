<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Get;

class Threads extends Component
{
    public function render(Request $request)
    {
        $sort = $request->sort;

        $get = new Get;
        $response['tables'] = $get->showTables($sort);
        $response['page'] = $request->page;

        return view('dashboard.threads', $response);
    }
}
