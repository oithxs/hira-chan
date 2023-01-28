<?php

namespace App\Services;

use App\Models\ClubThread;
use App\Models\CollegeYearThread;
use App\Models\DepartmentThread;
use App\Models\JobHuntingThread;
use App\Models\LectureThread;
use App\Repositories\HubRepository;
use App\Repositories\ThreadRepository;
use App\Services\ThreadService;
use App\Services\Support\HtmlSpecialCharsService;

class PostService
{
    private ThreadService $threadService;

    public function __construct()
    {
        $this->threadService = new ThreadService();
    }

    /**
     * スレッドに書き込みを行う
     *
     * @param string $threadId hubテーブルの`id`
     * @param string $userId usersテーブルの`id`
     * @param string $message スレッドに書き込む内容
     * @param string|null $reply 書き込みの返信先`message_id`
     * @return ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread
     */
    public function store(
        string $threadId,
        string $userId,
        string $message,
        string | null $reply
    ): ClubThread | CollegeYearThread | DepartmentThread | JobHuntingThread | LectureThread {
        return ThreadRepository::store(
            $this->threadService->getThreadClassName(
                HubRepository::getThreadPrimaryCategoryName($threadId)
            ),
            $threadId,
            $userId,
            $this->messageProcessing($message, $reply)
        );
    }

    /**
     * データの加工を行う
     *
     * @param string $message スレッドに書き込む内容
     * @param string|null $reply 書き込みの返信先`message_id`
     * @return string
     */
    public function messageProcessing(string $message, string | null $reply): string
    {
        $message = HtmlSpecialCharsService::encode($message);
        if ($reply !== null) {
            $message = $this->addReply($message, $reply);
        }
        return $message;
    }

    /**
     * 該当する `message_id` に移動するリンクを追加する
     *
     * @param string $text スレッドに書き込む内容
     * @param string $reply 書き込みの返信先`message_id`
     * @return string
     */
    public function addReply(string $text, string $reply): string
    {
        if ($reply !== null) {
            $reply = '<a class="bg-info" href="#thread_message_id_' . str_replace('>>> ', '', $reply) . '">' . $reply . '</a>';
            $text = $reply . '<br>' . $text;
        }
        return $text;
    }
}
