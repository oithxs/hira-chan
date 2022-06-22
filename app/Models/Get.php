<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Get extends Model {
	public function showTables() {
		switch($_SESSION["sort"]=$id){
			case'1':
				$sql = <<<EOF
		SELECT
			hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access 
		FROM
			hub
		LEFT OUTER JOIN
			access_logs
		ON
			hub.thread_id = access_logs.thread_id
		GROUP BY hub.thread_id 
		ORDER BY hub.created_at DESC;
		EOF;
		break;
			case'2':
			$sql = <<<EOF
			SELECT
				hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access 
			FROM
				hub
			LEFT OUTER JOIN
				access_logs
			ON
				hub.thread_id = access_logs.thread_id
			GROUP BY hub.thread_id 
			ORDER BY COUNT(access_logs.access_log) DESC,
			hub.created_at DESC;
			EOF;
			break;
		}
		$stmt = json_decode(json_encode(
			DB::connection('mysql_keiziban')->select($sql),
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
		
		$exists = DB::connection('mysql_keiziban')->select("SELECT * FROM hub WHERE thread_id = '$tableName'");
		if ($exists) {
			$stmt = DB::connection('mysql_keiziban')->select($sql);
		} else {
			$stmt = null;
		}
		
		return $stmt;
	}
}
