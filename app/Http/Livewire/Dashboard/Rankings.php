<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Get;

class Rankings extends Component
{
    public function render(Request $request)
    {
        $get = new Get;
        $response['access_ranking'] = $get->access_ranking();

        return view('dashboard.rankings', $response);
    }
}
