<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Record_AccessLog extends Model {
    public function func($thread_name, $thread_id, $user_email, $ip) {
        $thread_name = htmlspecialchars($thread_name, ENT_QUOTES, "UTF-8");
        $thread_id = htmlspecialchars($thread_id, ENT_QUOTES, "UTF-8");
        $user_email = htmlspecialchars($user_email, ENT_QUOTES, "UTF-8");

        $sql= <<<EOF
        INSERT INTO
        
            access_logs (
                id,
                time,
                user_email,
                thread_name,
                thread_id,
                access_log
            )
            VALUES(
                NULL,
                NOW(),
                :user_email,
                :thread_name,
                :thread_id,
                :access_log
            )
        EOF;
        DB::connection('mysql_keiziban')->insert(
            $sql, [
                'user_email' => $user_email, 
                'thread_name' => $thread_name,
                'thread_id' => $thread_id,
                'access_log' => $ip
            ]
        );

        return null;
    }
}
