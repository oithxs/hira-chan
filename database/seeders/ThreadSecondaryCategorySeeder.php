<?php

namespace Database\Seeders;

use App\Models\ThreadSecondaryCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThreadSecondaryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $club = 1;
        $college_year = 2;
        $department = 3;
        $job_hunting = 4;
        $lecture = 5;

        ThreadSecondaryCategory::updateOrCreate([
            'thread_primary_category_id' => $club,
            'name' => 'HxSコンピュータ部'
        ]);

        ThreadSecondaryCategory::updateOrCreate([
            'thread_primary_category_id' => $college_year,
            'name' => '1年生'
        ]);

        ThreadSecondaryCategory::updateOrCreate([
            'thread_primary_category_id' => $college_year,
            'name' => '2年生'
        ]);

        ThreadSecondaryCategory::updateOrCreate([
            'thread_primary_category_id' => $college_year,
            'name' => '3年生'
        ]);

        ThreadSecondaryCategory::updateOrCreate([
            'thread_primary_category_id' => $college_year,
            'name' => '4年生'
        ]);

        ThreadSecondaryCategory::updateOrCreate([
            'thread_primary_category_id' => $department,
            'name' => 'ID科'
        ]);

        ThreadSecondaryCategory::updateOrCreate([
            'thread_primary_category_id' => $department,
            'name' => 'IC科'
        ]);

        ThreadSecondaryCategory::updateOrCreate([
            'thread_primary_category_id' => $department,
            'name' => 'IS科'
        ]);

        ThreadSecondaryCategory::updateOrCreate([
            'thread_primary_category_id' => $department,
            'name' => 'IM科'
        ]);

        ThreadSecondaryCategory::updateOrCreate([
            'thread_primary_category_id' => $department,
            'name' => 'IN科'
        ]);

        ThreadSecondaryCategory::updateOrCreate([
            'thread_primary_category_id' => $job_hunting,
            'name' => '2022年度'
        ]);

        ThreadSecondaryCategory::updateOrCreate([
            'thread_primary_category_id' => $lecture,
            'name' => 'キャリア科目'
        ]);
    }
}
