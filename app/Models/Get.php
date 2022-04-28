<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Get extends Model {
	public function showTables() {
		$tables = DB::select("SHOW TABLES");
		$tableNameArray = array_reduce(
    		array_map(function ($table) {
				return array_values((array) $table);
    		}, $tables),
			'array_merge', []);

		return $tableNameArray;
	}
}
