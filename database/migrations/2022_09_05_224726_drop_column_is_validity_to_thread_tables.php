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
            $table->dropColumn('is_validity');
        });

        Schema::table('college_year_threads', function (Blueprint $table) {
            $table->dropColumn('is_validity');
        });

        Schema::table('department_threads', function (Blueprint $table) {
            $table->dropColumn('is_validity');
        });

        Schema::table('job_hunting_threads', function (Blueprint $table) {
            $table->dropColumn('is_validity');
        });

        Schema::table('lecture_threads', function (Blueprint $table) {
            $table->dropColumn('is_validity');
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
            $table->boolean('is_validity')->default(true)->after('message');
        });

        Schema::table('college_year_threads', function (Blueprint $table) {
            $table->boolean('is_validity')->default(true)->after('message');
        });

        Schema::table('department_threads', function (Blueprint $table) {
            $table->boolean('is_validity')->default(true)->after('message');
        });

        Schema::table('job_hunting_threads', function (Blueprint $table) {
            $table->boolean('is_validity')->default(true)->after('message');
        });

        Schema::table('lecture_threads', function (Blueprint $table) {
            $table->boolean('is_validity')->default(true)->after('message');
        });
    }
};
