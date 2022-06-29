<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\Hub;

class SelectThreadPages extends Component
{
    public function render(Request $request)
    {
        if ($request->category == NULL) {
            $RecordNum = Hub::count();
        } else {
            $RecordNum = Hub::where('thread_category', '=', $request->category)
                ->count();
        }
        return view('dashboard.select-thread-pages', [
            'max_thread' => $RecordNum,
            'sort' => $request->sort,
            'category' => $request->category
        ]);
    }
}
