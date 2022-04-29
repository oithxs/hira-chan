<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Send extends Model {
	public function insertComment($table, $name, $message) {
		DB::insert(
			"INSERT INTO $table(no, name, message, time) VALUES(NULL, :name, :message, NOW())", 
			[$name, $message]);
		return null;
	}
}
