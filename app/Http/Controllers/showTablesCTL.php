<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Get;


class showTablesCTL extends Controller
{
    public function __invoke()
    {
        $get = new Get;
        $stmt = $get->showTables();

        $response['tables'] = $stmt;
        $response['url'] = url('/');
        return view('hub', $response);
    }
}
