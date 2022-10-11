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
        Schema::table('hub', function (Blueprint $table) {
            $table->foreignId('thread_category_id')->after('id')->constrained('thread_categorys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hub', function (Blueprint $table) {
            $table->dropForeign(['thread_category_id']);
            $table->dropColumn('thread_category_id');
        });
    }
};
