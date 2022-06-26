<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\ThreadCategorys;

class Header extends Component
{
    public $categorys;
    public $category_types;

    public function mount(Request $request)
    {
        $this->categorys = ThreadCategorys::get();
        $this->category_types = ThreadCategorys::select('category_type')
            ->distinct('category_type')
            ->get();
    }

    public function render()
    {
        return view('dashboard.header');
    }
}
