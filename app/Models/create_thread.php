<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class create_thread extends Model {
    public function create_thread($tableName) {
        Schema::connection('mysql_keiziban')->create($tableName, function (Blueprint $table) {
            $table->id('no');
            $table->text('name');
            $table->text('message');
            $table->text('time');
        });

        return null;
    }

    public function insertTable($tableName) {
        DB::connection('mysql_keiziban')->insert(
        "INSERT INTO hub(id, table_name, created_at) VALUES(NULL, :table_name, NOW())", 
        [$tableName]);
        return null;
    }
}
