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
        Schema::table('hub', function (Blueprint $table) {
            $table->dropForeign(['thread_category_id']);
            $table->dropColumn('thread_category_id');
        });

        Schema::dropIfExists('thread_categorys');
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
        Schema::table('thread_categorys', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->string('category_type');
            $table->timestamps();
        });

        Schema::table('hub', function (Blueprint $table) {
            $table->foreignId('thread_category_id')->constrained('thread_categorys');
        });
    }
};
