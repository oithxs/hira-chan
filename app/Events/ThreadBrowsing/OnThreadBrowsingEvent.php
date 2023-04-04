<?php

namespace App\Events\ThreadBrowsing;

use App\Consts\ChannelConst;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OnThreadBrowsingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected string $threadId;

    protected mixed $response;

    /**
     * 新しいイベントインスタンスを作成する
     */
    public function __construct(string $threadId)
    {
        $this->threadId = $threadId;
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
