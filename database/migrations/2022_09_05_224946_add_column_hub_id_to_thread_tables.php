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
            $table->foreignUuid('hub_id')->after('id')->constrained('hub');
        });

        Schema::table('college_year_threads', function (Blueprint $table) {
            $table->foreignUuid('hub_id')->after('id')->constrained('hub');
        });

        Schema::table('department_threads', function (Blueprint $table) {
            $table->foreignUuid('hub_id')->after('id')->constrained('hub');
        });

        Schema::table('job_hunting_threads', function (Blueprint $table) {
            $table->foreignUuid('hub_id')->after('id')->constrained('hub');
        });

        Schema::table('lecture_threads', function (Blueprint $table) {
            $table->foreignUuid('hub_id')->after('id')->constrained('hub');
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
            $table->dropForeign(['hub_id']);
            $table->dropColumn('hub_id');
        });

        Schema::table('college_year_threads', function (Blueprint $table) {
            $table->dropForeign(['hub_id']);
            $table->dropColumn('hub_id');
        });

        Schema::table('department_threads', function (Blueprint $table) {
            $table->dropForeign(['hub_id']);
            $table->dropColumn('hub_id');
        });

        Schema::table('job_hunting_threads', function (Blueprint $table) {
            $table->dropForeign(['hub_id']);
            $table->dropColumn('hub_id');
        });

        Schema::table('lecture_threads', function (Blueprint $table) {
            $table->dropForeign(['hub_id']);
            $table->dropColumn('hub_id');
        });
    }
};
