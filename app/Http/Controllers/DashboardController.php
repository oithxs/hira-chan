<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Get;

class DashboardController extends Controller {
	public function __invoke(Request $request) {
		$get = new Get;
		$stmt = $get->access_ranking();

		$response['access_ranking'] = $stmt;
		return view('dashboard', $response);
	}
}