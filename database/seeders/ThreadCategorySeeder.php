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
            'category_name' => 'IS',
            'category_type' => 'Department'
        ]);

        ThreadCategory::create([
            'category_name' => 'IN',
            'category_type' => 'Department'
        ]);

        ThreadCategory::create([
            'category_name' => 'IC',
            'category_type' => 'Department'
        ]);

        ThreadCategory::create([
            'category_name' => 'ID',
            'category_type' => 'Department'
        ]);

        ThreadCategory::create([
            'category_name' => 'IM',
            'category_type' => 'Department'
        ]);
    }
}
