<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Get;

class keizibanCTL extends Controller {
	public function __invoke(Request $request) {
		$get = new Get;
		$stmt = $get->allRow($request->thread_id);

		$response['thread_name'] = $request->thread_name;
		$response['thread_id'] = $request->thread_id;
		$response['username'] = $request->user()->name;
		$response['url'] = url('/');
		$response['allRow'] = $stmt;
		return view('keiziban', $response);
	}
}