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
            $table->dropColumn('user_name');
        });

        Schema::table('college_year_threads', function (Blueprint $table) {
            $table->dropColumn('user_name');
        });

        Schema::table('department_threads', function (Blueprint $table) {
            $table->dropColumn('user_name');
        });

        Schema::table('job_hunting_threads', function (Blueprint $table) {
            $table->dropColumn('user_name');
        });

        Schema::table('lecture_threads', function (Blueprint $table) {
            $table->dropColumn('user_name');
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
            $table->string('user_name')->after('id');
        });

        Schema::table('college_year_threads', function (Blueprint $table) {
            $table->string('user_name')->after('id');
        });

        Schema::table('department_threads', function (Blueprint $table) {
            $table->string('user_name')->after('id');
        });

        Schema::table('job_hunting_threads', function (Blueprint $table) {
            $table->string('user_name')->after('id');
        });

        Schema::table('lecture_threads', function (Blueprint $table) {
            $table->string('user_name')->after('id');
        });
    }
};
