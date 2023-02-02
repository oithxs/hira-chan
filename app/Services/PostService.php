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
use Illuminate\Support\Collection;

class PostService
{
    private ThreadService $threadService;

    public function __construct()
    {
        $this->threadService = new ThreadService();
    }

    /**
     * スレッドの書き込みを取得する
     *
     * @param string $threadId 書き込みを取得するスレッドのID
     * @param string $userId 書き込みを取得するユーザのID
     * @param integer $preMaxMessageId 前回取得したメッセージIDの最大値
     * @return Collection 指定されたスレッドへの書き込み（すべて）
     */
    public function show(
        string $threadId,
        string $userId,
        int $preMaxMessageId
    ): Collection {
        return ThreadRepository::show(
            $this->threadService->getThreadClassName(
                HubRepository::getThreadPrimaryCategoryName($threadId)
            ),
            $threadId,
            $userId,
            $preMaxMessageId
        );
    }

    /**
     * スレッドに書き込みを行う
     *
     * @param string $threadId 書き込むスレッドのID
     * @param string $userId スレッドに書き込むユーザのID
     * @param string $message スレッドに書き込む内容
     * @param string|null $reply 書き込みの返信先`message_id`
     * @return ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread スレッド（テーブル）へ保存した書き込み
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
     * @param string $message 加工元の文字列
     * @param string|null $reply 書き込みの返信先`message_id`
     * @return string HTMLで表示可能にし，返信用のリンクを追加した文字列
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
     * @param string $text 加工元の文字列
     * @param string $reply 書き込みの返信先`message_id`
     * @return string 返信先へ移動できるリンクを追加した文字列
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
