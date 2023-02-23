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
        Schema::table('contact_administrators', function (Blueprint $table) {
            $table->dropColumn('type');
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
        Schema::table('contact_administrators', function (Blueprint $table) {
            $table->string('type')->after('message');
        });
    }
};
