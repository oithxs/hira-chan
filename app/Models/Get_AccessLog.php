<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Get_AccessLog extends Model {
    public function func($table, $user, $ip) {
        $sql= <<<EOF
        INSERT INTO
            $table (
                id,
                time,
                name,
                access_log
            )
            VALUES(
                id,
                now(),
                :usr_name,
                :access_log
            )
        EOF;
        DB::connection('mysql_access_log')->insert(
            $sql,
            [$user, $ip]
        );
        return null;
    }
}
