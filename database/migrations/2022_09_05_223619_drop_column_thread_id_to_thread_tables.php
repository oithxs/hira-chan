<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('club_threads', function (Blueprint $table) {
            $table->dropColumn('thread_id');
        });

        Schema::table('college_year_threads', function (Blueprint $table) {
            $table->dropColumn('thread_id');
        });

        Schema::table('department_threads', function (Blueprint $table) {
            $table->dropColumn('thread_id');
        });

        Schema::table('job_hunting_threads', function (Blueprint $table) {
            $table->dropColumn('thread_id');
        });

        Schema::table('lecture_threads', function (Blueprint $table) {
            $table->dropColumn('thread_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('club_threads', function (Blueprint $table) {
            $table->string('thread_id')->after('id');
        });

        Schema::table('college_year_threads', function (Blueprint $table) {
            $table->string('thread_id')->after('id');
        });

        Schema::table('department_threads', function (Blueprint $table) {
            $table->string('thread_id')->after('id');
        });

        Schema::table('job_hunting_threads', function (Blueprint $table) {
            $table->string('thread_id')->after('id');
        });

        Schema::table('lecture_threads', function (Blueprint $table) {
            $table->string('thread_id')->after('id');
        });
    }
};
