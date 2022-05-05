<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class create_thread extends Model {
    public function create_thread($tableName) {
        Schema::connection('mysql_keiziban')->create($tableName, function (Blueprint $table) {
            $table->integer('no', 11)->primary();
            $table->text('name');
            $table->text('message');
            $table->text('time');
        });
        return null;
    }
}
