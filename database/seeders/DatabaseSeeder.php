<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * アプリケーションのデータベースにデータを挿入する．
     *
     * @link https://readouble.com/laravel/9.x/ja/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserPageThemeSeeder::class);
        $this->call(ThreadCategorySeeder::class);
    }
}
