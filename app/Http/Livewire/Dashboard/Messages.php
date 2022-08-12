<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Hub;

class Messages extends Component
{
    /** @var string */
    public $thread_name;

    /** @var string */
    public $thread_id;

    /** @var int */
    public $result;

    /**
     * Storing data used on this page
     *
     * @param Illuminate\Http\Request $request
     * @return void
     */
    public function mount(Request $request)
    {
        $exists = Hub::where('thread_id', '=', $request->thread_id)->get();

        if ($exists) {
            $this->result = 1;
        } else {
            $this->result = 0;
        }

        $this->thread_name = $request->thread_name;
        $this->thread_id = $request->thread_id;
    }

    /**
     * Page Display
     *
     * @return Illuminate\Support\Facades\View
     */
    public function render()
    {
        return view('dashboard.messages');
    }
}
