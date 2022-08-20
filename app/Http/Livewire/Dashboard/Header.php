<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\ThreadCategorys;

class Header extends Component
{
    /** @var \Illuminate\Support\Collection */
    public $categorys;

    /** @var \Illuminate\Support\Collection */
    public $category_types;

    /**
     * Storing data used on this page
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function mount(Request $request)
    {
        $this->categorys = ThreadCategorys::get();
        $this->category_types = ThreadCategorys::select('category_type')
            ->distinct('category_type')
            ->get();
    }

    /**
     * Page Display
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function render()
    {
        return view('dashboard.header');
    }
}
