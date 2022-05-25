<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Record_AccessLog extends Model {
    public function func($thread, $user, $ip) {
        $thread = htmlspecialchars($thread,ENT_QUOTES,"UTF-8");

        $sql= <<<EOF
        INSERT INTO
        
            access_logs (
                id,
                time,
                user_id,
                thread_id,
                access_log
            )
            VALUES(
                NULL,
                NOW(),
                :usr_name,
                '$thread',
                :access_log
            )
        EOF;
        DB::connection('mysql_keiziban')->insert(
            $sql,
            [$user, $ip]
        );

        return null;
    }
}
