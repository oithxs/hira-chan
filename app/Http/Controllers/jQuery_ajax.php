<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Get;
use App\Models\Send;
use App\Models\create_thread;
use App\Models\Like;

class jQuery_ajax extends Controller {
	public function get_allRow(Request $request) {
		$get = new Get;
		$tableName = $request->post('table');
		$stmt = $get->allRow($tableName);
		return json_encode($stmt);
	}

	public function send_Row(Request $request) {
		$send = new Send;
		$message = $request->post('message');
		if (isset($message)) {
		$send->insertComment(
			$request->post('table'), 
			$request->user()->name, 
			$request->post('message')
		);}
		return null;
	}

	public function create_thread(Request $request) {
		$create = new create_thread;
		$create->insertTable($request->post('table'));
		$create->create_thread($request->post('table'));
		return null;
	}

	public function like(Request $request) {
		$thread_id = $request->thread_id;
		$message_id = $request->message_id;
		$user_id = $request->user()->id;

		$like = new Like;
		$like->like(
			$thread_id,
			$message_id,
			$user_id
		);

		return null;
	}
}