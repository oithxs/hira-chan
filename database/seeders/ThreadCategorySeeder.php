<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ThreadCategory;

class ThreadCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ThreadCategory::create([
            'category_name' => 'IS科',
            'category_type' => '学科'
        ]);

        ThreadCategory::create([
            'category_name' => 'IN科',
            'category_type' => '学科'
        ]);

        ThreadCategory::create([
            'category_name' => 'IC科',
            'category_type' => '学科'
        ]);

        ThreadCategory::create([
            'category_name' => 'ID科',
            'category_type' => '学科'
        ]);

        ThreadCategory::create([
            'category_name' => 'IM科',
            'category_type' => '学科'
        ]);
    }
}
