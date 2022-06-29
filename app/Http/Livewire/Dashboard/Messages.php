<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Hub;

class Messages extends Component
{
    public function render(Request $request)
    {
        $exists = Hub::where('thread_id', '=', $request->thread_id)->get();

        if ($exists) {
            $response['result'] = 1;
        } else {
            $response['result'] = 0;
        }

        $response['thread_name'] = $request->thread_name;
        $response['thread_id'] = $request->thread_id;

        return view('dashboard.messages', $response);
    }
}
