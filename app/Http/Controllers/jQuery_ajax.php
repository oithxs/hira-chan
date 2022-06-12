<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Get;
use App\Models\Send;
use App\Models\create_thread;
use App\Models\Like;
use App\Models\AdminActions;

class jQuery_ajax extends Controller {
	public function get_allRow(Request $request) {
		$get = new Get;
		$tableName = $request->post('table');
		$stmt = $get->allRow(
			$tableName,
			$request->user()->email
		);

		return json_encode($stmt);
	}

	public function send_Row(Request $request) {
		$send = new Send;
		$message = $request->post('message');
		if (isset($message)) {
		$send->insertComment(
			$request->post('table'), 
			$request->user()->name, 
			$request->user()->email,
			$request->post('message')
		);}
		return null;
	}

	public function create_thread(Request $request) {
		$create = new create_thread;
		$uuid = str_replace("-", "", Str::uuid());
		$create->insertTable(
			$request->post('table'),
			$uuid,
			$request->user()->email
		);
		$create->create_thread($uuid);
		return null;
	}

	public function like(Request $request) {
		$thread_id = $request->thread_id;
		$message_id = $request->message_id;
		$user_email = $request->user()->email;

		$like = new Like;
		$like->like(
			$thread_id,
			$message_id,
			$user_email
		);

		return null;
	}

	public function unlike(Request $request) {
		$thread_id = $request->thread_id;
		$message_id = $request->message_id;
		$user_email = $request->user()->email;

		$like = new Like;
		$like->unlike(
			$thread_id,
			$message_id,
			$user_email
		);
		return null;
	}

	public function delete_thread(Request $request) {
		$thread_id = $request->thread_id;

		$admin_actions = new AdminActions;
		$admin_actions->delete_thread($thread_id);
		$admin_actions->delete_thread_record($thread_id);

		return null;
	}

	public function edit_thread(Request $request) {
		$thread_id = $request->thread_id;
		$thread_name = $request->thread_name;

		$admin_actions = new AdminActions;
		$admin_actions->edit_thread_record($thread_id, $thread_name);

		return null;
	}

	public function delete_message(Request $request) {
		$thread_id = $request->thread_id;
		$message_id = $request->message_id;

		$admin_actions = new AdminActions;
		$admin_actions->delete_message_record($thread_id, $message_id);

		return null;
	}

	public function restore_message(Request $request) {
		$thread_id = $request->thread_id;
		$message_id = $request->message_id;

		$admin_actions = new AdminActions;
		$admin_actions->restore_message_record($thread_id, $message_id);

		return null;
	}
}