<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * `php artisan migrate` で実行
     *
     * @link https://readouble.com/laravel/9.x/ja/migrations.html
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thread_secondary_categorys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thread_primary_category_id')->constrained('thread_primary_categorys');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * `php artisan migrate:rollback` で実行
     *
     * @link https://readouble.com/laravel/9.x/ja/migrations.html
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thread_secondary_categorys');
    }
};
