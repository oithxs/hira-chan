<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class showTablesCTL extends Controller {
	public function __invoke() {
		$tables = DB::select("SHOW TABLES");

		$tableNameArray = array_reduce(
    		array_map(function ($table) {
				return array_values((array) $table);
    		}, $tables),
			'array_merge', []);
		
		$response['tables'] = $tableNameArray;
		return view('home', $response);
	}
}