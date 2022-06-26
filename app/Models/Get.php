<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Get extends Model
{
    public function allRow($tableName, $user_email)
    {
        $tableName = htmlspecialchars($tableName,  ENT_QUOTES, 'UTF-8');
        $sql = <<<EOF
        SELECT
            $tableName.*,
            COUNT(likes.user_email) AS count_user,
            COALESCE((
                SELECT
                    1
                 FROM
                    likes
                WHERE
                    likes.user_email = '$user_email' AND
                    '$tableName' = likes.thread_id AND
                    $tableName.no = likes.message_id), 0)
                    AS user_like
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
            $stmt = 0;
        }

        return $stmt;
    }

    public function access_ranking()
    {
        $sql = <<<EOF
        SELECT
            hub.thread_name, COUNT(*) AS access_count
        FROM
            hub
        RIGHT OUTER JOIN
            access_logs
            ON
                access_logs.thread_id = hub.thread_id
        WHERE
            hub.thread_name IS NOT NULL
        GROUP BY hub.thread_id
        ORDER BY COUNT(*) DESC;
        EOF;

        $stmt = json_decode(json_encode(
            DB::connection('mysql_keiziban')->select($sql),
        ), true);
        return $stmt;
    }
}
