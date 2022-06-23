<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Get;
use Illuminate\Http\Request;

class showTablesCTL extends Controller
{
    public function __invoke(Request $request)
    {
        $type = $request->type;
        if ($type == NULL) {
            $type = 'new_create';
        }

        $get = new Get;
        $stmt = $get->showTables($type);

        $response['tables'] = $stmt;
        $response['url'] = url('/');
        return view('hub', $response);
    }
}
