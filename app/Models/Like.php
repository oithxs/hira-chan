<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Like extends Model
{
    public function like($thread_id, $message_id, $user_email)
    {
        $thread_id = htmlspecialchars($thread_id, ENT_QUOTES, 'UTF-8');

        $query = <<<EOF
        INSERT INTO
            likes
        SELECT
            NULL,
            '$thread_id',
            $message_id,
            '$user_email',
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
                    user_email = :user_email
            );
        EOF;

        DB::connection('mysql_keiziban')->insert(
            $query,
            [
                'thread_id' => $thread_id,
                'message_id' => $message_id,
                'user_email' => $user_email,
            ]
        );
        return null;
    }

    public function unlike($thread_id, $message_id, $user_email)
    {
        $thread_id = htmlspecialchars($thread_id, ENT_QUOTES, 'UTF-8');

        $query = <<<EOF
        DELETE
        FROM
            likes
        WHERE
            likes.thread_id = '$thread_id' AND
            likes.message_id = $message_id AND
            likes.user_email = '$user_email'
        EOF;

        DB::connection('mysql_keiziban')->delete($query);
        return null;
    }
}
