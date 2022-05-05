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
		$sql = "SELECT * FROM $tableName ORDER BY no DESC";
		$stmt = DB::connection('mysql_keiziban')->select($sql);
		return $stmt;
	}
}
