<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class SendComment extends Component
{
    /**
     * Page Display
     *
     * @return Illuminate\Support\Facades\View
     */
    public function render()
    {
        return view('dashboard.send-comment');
    }
}
