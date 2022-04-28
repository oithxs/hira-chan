<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Get;

class jQuery_ajax extends Controller {
	public function __invoke(Request $request) {
		$get = new Get;
		$tableName = $request->post('table');
		$stmt = $get->allRow($tableName);
		return json_encode($stmt);
	}
}