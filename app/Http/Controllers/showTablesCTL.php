<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Get;


class showTablesCTL extends Controller {
	public function __invoke() {
		$get = new Get;
		$tableNameArray = $get->showTables();
		
		$response['tables'] = $tableNameArray;
		return view('hub', $response);
	}
}