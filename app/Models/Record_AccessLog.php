<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Record_AccessLog extends Model {
    public function func($table, $user, $ip) {
        $table = htmlspecialchars($table,ENT_QUOTES,"UTF-8");
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
