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
        Schema::table('club_threads', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('college_year_threads', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('department_threads', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('job_hunting_threads', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('lecture_threads', function (Blueprint $table) {
            $table->softDeletes();
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
        Schema::table('club_threads', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('college_year_threads', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('department_threads', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('job_hunting_threads', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('lecture_threads', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
