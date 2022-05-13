<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Get extends Model {
	public function showTables() {
		$stmt = json_decode(json_encode(
			DB::connection('mysql_keiziban')->select("SELECT * FROM hub"),
		), true);
		return $stmt;
	}

	public function allRow($tableName) {
		$tableName = htmlspecialchars($tableName,  ENT_QUOTES, 'UTF-8');
		$sql = <<<EOF
		SELECT
			$tableName.*, COALESCE(COUNT(likes.user_id), 0) AS count_user
		FROM 
			$tableName
		LEFT OUTER JOIN
			likes
		ON 
			'$tableName' = likes.thread_id AND
			$tableName.no = likes.message_id
		GROUP BY $tableName.no;
		EOF;
		$stmt = DB::connection('mysql_keiziban')->select($sql);
		return $stmt;
	}
}
