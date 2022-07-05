<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ThreadCategorys;

class ThreadCategorysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThreadCategorys::updateOrCreate([
            'category_name' => 'IS科',
            'category_type' => '学科'
        ]);

        ThreadCategorys::updateOrCreate([
            'category_name' => 'IN科',
            'category_type' => '学科'
        ]);

        ThreadCategorys::updateOrCreate([
            'category_name' => 'IC科',
            'category_type' => '学科'
        ]);

        ThreadCategorys::updateOrCreate([
            'category_name' => 'ID科',
            'category_type' => '学科'
        ]);

        ThreadCategorys::updateOrCreate([
            'category_name' => 'IM科',
            'category_type' => '学科'
        ]);

        ThreadCategorys::updateOrCreate([
            'category_name' => '1年生',
            'category_type' => '学年'
        ]);

        ThreadCategorys::updateOrCreate([
            'category_name' => '2年生',
            'category_type' => '学年'
        ]);

        ThreadCategorys::updateOrCreate([
            'category_name' => '3年生',
            'category_type' => '学年'
        ]);

        ThreadCategorys::updateOrCreate([
            'category_name' => '4年生',
            'category_type' => '学年'
        ]);

        ThreadCategorys::updateOrCreate([
            'category_name' => 'HxSコンピュータ部',
            'category_type' => '部活'
        ]);

        ThreadCategorys::updateOrCreate([
            'category_name' => 'キャリア科目',
            'category_type' => '授業'
        ]);

        ThreadCategorys::updateOrCreate([
            'category_name' => '2022年度',
            'category_type' => '就職'
        ]);
    }
}
