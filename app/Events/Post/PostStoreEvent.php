<?php

namespace App\Events\Post;

use App\Consts\ChannelConst;
use App\Http\Resources\PostResource;
use App\Models\ThreadModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * スレッドに書き込みが行われた際に発生するイベント
 *
 * スレッドに追加された書き込みを受け取る
 */
class PostStoreEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $threadId;

    private PostResource $response;

    /**
     * 新しいイベントインスタンスを作成する
     */
    public function __construct(string $threadId, ThreadModel $post)
    {
        $this->threadId = $threadId;
        $this->response = new PostResource(collect([$post]));
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
