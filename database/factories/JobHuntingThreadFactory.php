<?php

namespace Database\Factories;

use App\Models\JobHuntingThread;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobHuntingThread>
 */
class JobHuntingThreadFactory extends ThreadFactory
{
    /**
     * factory の対象モデル．
     *
     * @link https://readouble.com/laravel/9.x/ja/database-testing.html
     *
     * @var string
     */
    protected $model = JobHuntingThread::class;
}
