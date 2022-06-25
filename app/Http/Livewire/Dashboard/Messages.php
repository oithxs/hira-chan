<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Get;

class Messages extends Component
{
    public function render(Request $request)
    {
        $get = new Get;
        $messages = $get->allRow(
            $request->thread_id,
            $request->user()->email
        );

        if ($messages == 0) {
            $response['result'] = 0;
        } else {
            $response['result'] = 1;
        }

        $response['thread_name'] = $request->thread_name;
        $response['thread_id'] = $request->thread_id;

        return view('dashboard.messages', $response);
    }
}
