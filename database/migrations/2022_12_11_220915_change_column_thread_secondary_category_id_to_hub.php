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
            $table->foreignId('thread_secondary_category_id')->after('id')->constrained('thread_secondary_categorys');
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
        Schema::table('hub', function (Blueprint $table) {
            $table->dropForeign(['thread_secondary_category_id']);
            $table->dropColumn('thread_secondary_category_id');
        });
    }
};
