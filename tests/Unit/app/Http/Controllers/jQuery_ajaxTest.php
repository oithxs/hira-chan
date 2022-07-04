<?php

namespace Tests\Unit\app\Http\Controllers;

use Tests\TestCase;
use App\Models\ThreadCategorys;

class jQuery_ajaxTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_category_type()
    {
        $category = ThreadCategorys::where('category_name', '=', 'IS科')->first();

        if ($category->category_type == '学科') {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }
}
