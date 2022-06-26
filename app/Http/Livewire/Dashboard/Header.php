<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Header extends Component
{
    public $categorys;
    public $category_types;

    public function mount(Request $request)
    {
        $this->categorys = DB::connection('mysql')->table('thread_categorys')->get();
        $this->category_types = DB::connection('mysql')->table('thread_categorys')->select('category_type')->distinct('category_type')->get();

        Log::debug($this->category_types);
    }

    public function render()
    {
        return view('dashboard.header');
    }
}
