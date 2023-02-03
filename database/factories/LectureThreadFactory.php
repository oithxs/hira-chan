<?php

namespace Database\Factories;

use App\Models\LectureThread;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LectureThread>
 */
class LectureThreadFactory extends ThreadFactory
{
    /**
     * factory の対象モデル．
     *
     * @link https://readouble.com/laravel/9.x/ja/database-testing.html
     *
     * @var string
     */
    protected $model = LectureThread::class;
}
