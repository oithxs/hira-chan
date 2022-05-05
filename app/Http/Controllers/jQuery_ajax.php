<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Get;
use App\Models\Send;
use App\Models\create_thread;

class jQuery_ajax extends Controller {
	public function get_allRow(Request $request) {
		$get = new Get;
		$tableName = $request->post('table');
		$stmt = $get->allRow($tableName);
		return json_encode($stmt);
	}

	public function send_Row(Request $request) {
		$send = new Send;
		$send->insertComment(
			$request->post('table'), 
			$request->user()->name, 
			$request->post('message')
		);
		return null;
	}

	public function create_thread(Request $request) {
		$create = new create_thread;
		$create->create_thread($request->post('table'));
		return null;
	}
}