<?php

namespace App\Events\Post;

use App\Http\Resources\PostResource;
use App\Models\Hub;
use App\Models\ThreadModel;
use Error;
use Exception;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class PostStoreEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $threadId;

    private PostResource $response;

    /**
     * 新しいイベントインスタンスを作成します.
     */
    public function __construct(string $threadId, ThreadModel $post)
    {
        $this->threadId = $threadId;
        $this->response = new PostResource(collect([$post]));
    }

    /**
     * イベントが放送されるべきチャンネルを取得します
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('threadBrowsing.' . $this->threadId),
        ];
    }

    /**
     * ブロードキャストされるデータを取得する
     *
     * @return
     */
    public function broadcastWith()
    {
        return $this->response->toArray();
    }
}
