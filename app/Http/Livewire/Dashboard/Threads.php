<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Get;
use Illuminate\Support\Facades\DB;

class Threads extends Component
{
    public $threads;
    public $categorys;

    public function mount(Request $request)
    {
        $get = new Get;
        $this->threads = $get->showTables($request->sort, $request->category);
        $this->categorys = DB::connection('mysql')->table('thread_categorys')->get();
    }

    public function render(Request $request)
    {
        $response['tables'] = $this->threads;
        $response['category'] = $request->category;
        $response['page'] = $request->page;

        return view('dashboard.threads', $response);
    }

    public function new_create()
    {
        $get = new Get;
        $this->threads = $get->showTables('new_create', NULL);
    }

    public function access_count()
    {
        $get = new Get;
        $this->threads = $get->showTables('access_count', NULL);
    }
}
