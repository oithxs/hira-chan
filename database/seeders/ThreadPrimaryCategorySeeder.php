<?php

namespace Database\Seeders;

use App\Models\ThreadPrimaryCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThreadPrimaryCategorySeeder extends Seeder
{
    /**
     * thread primary category の初期データ
     *
     * @link https://readouble.com/laravel/9.x/ja/seeding.html
     *
     * @return void
     */
    public function run()
    {
        // id = 1
        ThreadPrimaryCategory::updateOrCreate([
            'name' => '部活'
        ]);

        // id = 2
        ThreadPrimaryCategory::updateOrCreate([
            'name' => '学年'
        ]);

        // id = 3
        ThreadPrimaryCategory::updateOrCreate([
            'name' => '学科'
        ]);

        // id = 4
        ThreadPrimaryCategory::updateOrCreate([
            'name' => '就職'
        ]);

        // id = 5
        ThreadPrimaryCategory::updateOrCreate([
            'name' => '授業'
        ]);
    }
}
