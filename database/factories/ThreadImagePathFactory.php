<?php

namespace Database\Factories;

use App\Models\ClubThread;
use App\Models\CollegeYearThread;
use App\Models\DepartmentThread;
use App\Models\Hub;
use App\Models\JobHuntingThread;
use App\Models\LectureThread;
use App\Models\ThreadImagePath;
use App\Models\ThreadSecondaryCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ThreadImagePath>
 */
class ThreadImagePathFactory extends Factory
{
    /**
     * factory の対象モデル．
     *
     * @link https://readouble.com/laravel/9.x/ja/database-testing.html
     *
     * @var string
     */
    protected $model = ThreadImagePath::class;

    /**
     * モデルのデフォルトの状態を定義する．
     *
     * @link https://readouble.com/laravel/9.x/ja/database-testing.html
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $random = random_int(
            ThreadSecondaryCategory::first()->id,
            ThreadSecondaryCategory::orderByDesc('id')->first()->id
        );
        $thread = Hub::factory()->create([
            'thread_secondary_category_id' => $random
        ]);
        $thread_table = '';
        switch ($thread->thread_secondary_category()->first()->thread_primary_category()->first()->name) {
            case '部活':
                $thread_table = ClubThread::class;
                break;
            case '学年':
                $thread_table = CollegeYearThread::class;
                break;
            case '学年':
                $thread_table = DepartmentThread::class;
                break;
            case '就職':
                $thread_table = DepartmentThread::class;
                break;
            case '授業':
                $thread_table = JobHuntingThread::class;
                break;
            default:
                $thread_table = ClubThread::class;
        }
        $post = $thread_table::factory()->create();

        return [
            'club_thread_id' => $post instanceof ClubThread ? $post->id : null,
            'college_year_thread_id' => $post instanceof CollegeYearThread ? $post->id : null,
            'department_thread_id' => $post instanceof DepartmentThread ? $post->id : null,
            'job_hunting_thread_id' => $post instanceof JobHuntingThread ? $post->id : null,
            'lecture_thread_id' => $post instanceof LectureThread ? $post->id : null,
            'user_id' => User::factory()->create(),
            'img_path' => $this->faker->unique()->uuid(),
            'img_size' => $this->faker->randomNumber()
        ];
    }

    /**
     * 書き込んだスレッドのインスタンスにいいねをつける
     *
     * @param \App\Models\ClubThread |
     *        \App\Models\CollegeYearThread |
     *        \App\Models\DepartmentThread |
     *        \App\Models\JboHuntingThread |
     *        \App\Models\LectureThread $thread
     * @return LikeFactory
     */
    public function post($thread): ThreadImagePathFactory
    {
        $club_thread_id = ClubThread::where('hub_id', '=', $thread->hub_id)
            ->where('message_id', '=', $thread->message_id)
            ->first()
            ->id ?? null;
        $college_year_thread_id = CollegeYearThread::where('hub_id', '=', $thread->hub_id)
            ->where('message_id', '=', $thread->message_id)
            ->first()
            ->id ?? null;
        $department_thread_id = DepartmentThread::where('hub_id', '=', $thread->hub_id)
            ->where('message_id', '=', $thread->message_id)
            ->first()
            ->id ?? null;
        $job_hunting_thread_id = JobHuntingThread::where('hub_id', '=', $thread->hub_id)
            ->where('message_id', '=', $thread->message_id)
            ->first()
            ->id ?? null;
        $lecture_thread_id = LectureThread::where('hub_id', '=', $thread->hub_id)
            ->where('message_id', '=', $thread->message_id)
            ->first()
            ->id ?? null;

        return $this->state(function (array $attributes) use (
            $club_thread_id,
            $college_year_thread_id,
            $department_thread_id,
            $job_hunting_thread_id,
            $lecture_thread_id,
        ) {
            return [
                'club_thread_id' => $club_thread_id,
                'college_year_thread_id' => $college_year_thread_id,
                'department_thread_id' => $department_thread_id,
                'job_hunting_thread_id' => $job_hunting_thread_id,
                'lecture_thread_id' => $lecture_thread_id,
            ];
        });
    }
}
