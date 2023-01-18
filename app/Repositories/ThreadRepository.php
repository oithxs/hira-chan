<?php

namespace App\Repositories;

use App\Models\ClubThread;
use App\Models\CollegeYearThread;
use App\Models\DepartmentThread;
use App\Models\JobHuntingThread;
use App\Models\LectureThread;

class ThreadRepository
{
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
}
