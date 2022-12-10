<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Hub;
use Illuminate\Http\Request;
use Livewire\Component;

class Messages extends Component
{
    /**
     * スレッド名
     *
     * @var string
     */
    public $thread_name;

    /**
     * スレッド（Hub）ID
     *
     * @var string
     */
    public $thread_id;

    /**
     * スレッドが存在しているかどうか
     *
     * @todo 現状，スレッドが表示しない場合にそれを旨を表示出来ていない
     *
     * @var int
     */
    public $result;

    /**
     * このページで使用するデータ定義
     *
     * @link https://laravel-livewire.com/docs/2.x/rendering-components
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function mount(Request $request)
    {
        $exists = Hub::where('id', '=', $request->thread_id)
            ->get();

        if ($exists) {
            $this->result = 1;
        } else {
            $this->result = 0;
        }

        $this->thread_name = $request->thread_name;
        $this->thread_id = $request->thread_id;
    }

    /**
     * スレッドにアクセスしている時の書き込み表示欄を表示する
     *
     * @link https://laravel-livewire.com/docs/2.x/rendering-components
     * @see resources/views/dashboard/messages.blade.php
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function render()
    {
        return view('dashboard.messages');
    }
}
