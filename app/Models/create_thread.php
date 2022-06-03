<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class create_thread extends Model {
    public function create_thread($thread_id) {
        Schema::connection('mysql_keiziban')->create($thread_id, function (Blueprint $table) {
            $table->id('no');
            $table->text('name');
            $table->text('user_email');
            $table->text('message');
            $table->text('time');
        });
        
        return null;
    }

    public function insertTable($tableName, $thread_id, $user_email) {
        $query = <<<EOF
        INSERT INTO
            hub(
                thread_id,
                thread_name,
                user_email,
                created_at
            )
        VALUES(
            :thread_id,
            :thread_name,
            :user_email,
            NOW()
        )
        EOF;

        DB::connection('mysql_keiziban')->insert(
        $query, [
            'thread_id' => $thread_id, 
            'thread_name' => $tableName, 
            'user_email' => $user_email
        ]);
        return null;
    }
}
