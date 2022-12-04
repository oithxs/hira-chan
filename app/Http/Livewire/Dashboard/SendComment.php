<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class SendComment extends Component
{
    /**
     * スレッドにアクセスした際にスレッドに書き込みを行うための入力（Form）部分
     *
     * @link https://laravel-livewire.com/docs/2.x/rendering-components
     * @see resources/views/dashboard/send-comment.blade.php
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function render()
    {
        return view('dashboard.send-comment');
    }
}
