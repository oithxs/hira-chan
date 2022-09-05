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
            $table->foreignUuid('user_id')->after('hub_id')->constrained('users');
        });

        Schema::table('college_year_threads', function (Blueprint $table) {
            $table->foreignUuid('user_id')->after('hub_id')->constrained('users');
        });

        Schema::table('department_threads', function (Blueprint $table) {
            $table->foreignUuid('user_id')->after('hub_id')->constrained('users');
        });

        Schema::table('job_hunting_threads', function (Blueprint $table) {
            $table->foreignUuid('user_id')->after('hub_id')->constrained('users');
        });

        Schema::table('lecture_threads', function (Blueprint $table) {
            $table->foreignUuid('user_id')->after('hub_id')->constrained('users');
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
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('college_year_threads', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('department_threads', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('job_hunting_threads', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('lecture_threads', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
