<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Get extends Model {
	public function showTables() {
		$sql = <<<EOF
		SELECT
		 * 
		FROM
			hub
		EOF;
		$stmt = json_decode(json_encode(
			DB::connection('mysql_keiziban')->select($sql),
		), true);
		return $stmt;
	}

	public function allRow($tableName) {
		$tableName = htmlspecialchars($tableName,  ENT_QUOTES, 'UTF-8');
		$sql = <<<EOF
		SELECT
			$tableName.*, 
			COUNT(likes.user_id) AS count_user,
			COALESCE((
				SELECT 
					1 
				 FROM 
					likes 
				WHERE 
					likes.user_id = 1 AND 
					'$tableName' = likes.thread_id AND 
					$tableName.no = likes.message_id), 0) 
					AS user_like
		FROM 
			$tableName
		LEFT OUTER JOIN
			likes
		ON 
			'$tableName' = likes.thread_id AND
			$tableName.no = likes.message_id
		GROUP BY $tableName.no;
		EOF;
		
		$exists = DB::connection('mysql_keiziban')->select("SELECT * FROM hub WHERE thread_id = '$tableName'");
		if ($exists) {
			$stmt = DB::connection('mysql_keiziban')->select($sql);
		} else {
			$stmt = null;
		}
		
		return $stmt;
	}
}
