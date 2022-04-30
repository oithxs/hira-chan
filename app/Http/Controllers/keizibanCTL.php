<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Get;

class keizibanCTL extends Controller {
	public function __invoke(Request $request) {
		$get = new Get;
		$stmt = $get->allRow($request->get('table')[0]);

		$response['tableName'] = $request->get('table')[0];
		$response['url'] = url('/');
		$response['allRow'] = $stmt;
		return view('keiziban', $response);
	}
}