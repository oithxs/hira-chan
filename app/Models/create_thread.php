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
            $table->text('user_id');
            $table->text('message');
            $table->text('time');
        });
        
        return null;
    }

    public function insertTable($tableName, $thread_id, $user_id) {
        DB::connection('mysql_keiziban')->insert(
        "INSERT INTO hub(id, thread_id, thread_name, user_id, created_at) VALUES(NULL, :thread_id, :thread_name, :user_id, NOW())", 
        [$thread_id, $tableName, $user_id]);
        return null;
    }
}
