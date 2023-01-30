<?php

namespace App\Repositories;

use App\Models\ClubThread;
use App\Models\CollegeYearThread;
use App\Models\DepartmentThread;
use App\Models\Hub;
use App\Models\JobHuntingThread;
use App\Models\LectureThread;
use App\Models\ThreadPrimaryCategory;
use App\Models\ThreadSecondaryCategory;
use Illuminate\Support\Collection;

class ThreadRepository
{
    /**
     * スレッドの書き込みを取得する
     *
     * @param string $threadModelFQCN 書き込みを取得するモデルクラスまでの完全修飾クラス名
     * @param string $threadId 取得するスレッドのID
     * @param string $userId ログインしているユーザID
     * @param integer $preMaxMessageId 前回取得したメッセージIDの最大値
     * @return Collection
     */
    public static function show(
        string $threadModelFQCN,
        string $threadId,
        string $userId,
        int $preMaxMessageId
    ): Collection {
        return $threadModelFQCN::with([
            'user',
            'thread_image_path',
            'likes' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ])
            ->withCount('likes')
            ->where([
                ['hub_id', $threadId],
                ['message_id', '>', $preMaxMessageId]
            ])
            ->get();
    }

    /**
     * スレッドに書き込みを行う
     *
     * @param string $threadClassName
     * @param string $threadId
     * @param string $userId
     * @param string $message
     * @return ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread
     */
    public static function store(
        string $threadClassName,
        string $threadId,
        string $userId,
        string $message
    ): ClubThread | CollegeYearThread | DepartmentThread | JobHuntingThread | LectureThread {
        return $threadClassName::create([
            'hub_id' => $threadId,
            'user_id' => $userId,
            'message_id' => self::getMaxMessageId($threadClassName, $threadId) + 1 ?? 0,
            'message' => $message
        ]);
    }

    /**
     * スレッドの最大 `message_id` を取得する
     *
     * @param string $threadClassName
     * @param string $threadId
     * @return integer|null
     */
    public static function getMaxMessageId(
        string $threadClassName,
        string $threadId
    ): int | null {
        return $threadClassName::where('hub_id', '=', $threadId)->max('message_id');
    }

    /**
     * 書き込みの `id` を取得する
     *
     * @param ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread $post
     * @return string
     */
    public static function getId(
        ClubThread | CollegeYearThread | DepartmentThread | JobHuntingThread | LectureThread $post
    ): string {
        return $post->id;
    }

    /**
     * 書き込みの `hub_id` を取得する
     *
     * @param ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread $post
     * @return string
     */
    public static function getHubId(
        ClubThread | CollegeYearThread | DepartmentThread | JobHuntingThread | LectureThread $post
    ): string {
        return $post->hub_id;
    }

    /**
     * 書き込みからスレッドを取得する
     *
     * @param ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread $post
     * @return Hub
     */
    public static function postToHub(
        ClubThread | CollegeYearThread | DepartmentThread | JobHuntingThread | LectureThread $post
    ): Hub {
        return $post->hub;
    }

    /**
     * 書き込みから詳細カテゴリを取得する
     *
     * @param ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread $post
     * @return ThreadSecondaryCategory
     */
    public static function postToThreadSecondaryCategory(
        ClubThread | CollegeYearThread | DepartmentThread | JobHuntingThread | LectureThread $post
    ): ThreadSecondaryCategory {
        return self::postToHub($post)->thread_secondary_category;
    }

    /**
     * 書き込みから大枠カテゴリを取得する
     *
     * @param ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread $post
     * @return ThreadPrimaryCategory
     */
    public static function postToThreadPrimaryCategory(
        ClubThread | CollegeYearThread | DepartmentThread | JobHuntingThread | LectureThread $post
    ): ThreadPrimaryCategory {
        return self::postToThreadSecondaryCategory($post)->thread_primary_category;
    }

    /**
     * 書き込みから大枠カテゴリ名を取得する
     *
     * @param ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread $post
     * @return string
     */
    public static function postToThreadPrimaryCategoryName(
        ClubThread | CollegeYearThread | DepartmentThread | JobHuntingThread | LectureThread $post
    ): string {
        return self::postToThreadPrimaryCategory($post)->name;
    }
}
