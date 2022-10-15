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
        Schema::table('thread_image_paths', function (Blueprint $table) {
            $table->foreignId('department_thread_id')->nullable(true)->after('college_year_thread_id')->constrained('department_threads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('thread_image_paths', function (Blueprint $table) {
            $table->dropForeign(['department_thread_id']);
            $table->dropColumn('department_thread_id');
        });
    }
};
