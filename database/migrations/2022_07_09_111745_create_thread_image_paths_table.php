<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadImagePathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thread_image_paths', function (Blueprint $table) {
            $table->id();
            $table->string('thread_id');
            $table->string('message_id');
            $table->string('user_email');
            $table->string('img_path');
            $table->integer('img_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thread_image_paths');
    }
}
