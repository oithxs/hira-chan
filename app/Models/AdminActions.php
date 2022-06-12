<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminActions extends Model {
	public function delete_thread($thread_id) {
        $query = <<<EOF
		DROP TABLE $thread_id
		EOF;

		DB::connection('mysql_keiziban')->statement($query);
		return null;
	}

	public function delete_thread_record($thread_id) {
		$query = <<<EOF
		DELETE
		FROM
			hub
		WHERE
			hub.thread_id = '$thread_id'
		EOF;

		DB::connection('mysql_keiziban')->statement($query);
		return null;
	}

	public function edit_thread_record($thread_id, $thread_name) {
		$query = <<<EOF
		UPDATE
			hub
		SET
			hub.thread_name = '$thread_name'
		WHERE
			hub.thread_id = '$thread_id'
		EOF;

		DB::connection('mysql_keiziban')->statement($query);
		return null;
	}
}
