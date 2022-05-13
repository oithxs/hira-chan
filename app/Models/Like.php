<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Like extends Model {
    public function like($thread_id, $message_id, $user_id) {
        $thread_id = htmlspecialchars($thread_id, ENT_QUOTES, 'UTF-8');
        
        $query =<<<EOM
        INSERT INTO
            likes
        SELECT
            NULL,
            '$thread_id',
            $message_id,
            $user_id,
            NOW(),
            NULL
        FROM
            DUAL
        WHERE
            NOT EXISTS(
                SELECT
                    *
                FROM
                    likes
                WHERE
                    thread_id = :thread_id AND
                    message_id = :message_id AND
                    user_id = :user_id
            );
        EOM;
        
        DB::connection('mysql_keiziban')->insert(
            $query, [
                'thread_id' => $thread_id, 
                'message_id' => $message_id, 
                'user_id' => $user_id,
            ]
        );
        return null;
    }
}
