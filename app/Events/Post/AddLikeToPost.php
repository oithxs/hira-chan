<?php

namespace App\Events\Post;

use App\Consts\ChannelConst;
use App\Http\Resources\PostLikeResource;
use App\Models\ThreadModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * 書き込みにいいねがされた際に発生するイベント
 *
 * 書き込みにされたいいね数を受け取る
 */
class AddLikeToPost implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $threadId;

    private PostLikeResource $response;

    /**
     * 新しいイベントインスタンスを作成する
     */
    public function __construct(string $threadId, ThreadModel $post)
    {
        $this->threadId = $threadId;
        $this->response = new PostLikeResource(collect($post));
    }

    /**
     * イベントが放送されるべきチャンネルを取得する
     *
     * チャンネル名 => threadBrowsing.<スレッドID>
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel(ChannelConst::THREAD_BROWSING . $this->threadId),
        ];
    }

    /**
     * ブロードキャストされるデータを取得する
     *
     * @return array 追加された書き込み
     */
    public function broadcastWith()
    {
        return $this->response->toArray();
    }
}
