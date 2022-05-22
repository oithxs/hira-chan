<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\MailForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Tab;

class MailController extends Controller
{
    public function show(Request $request, Content $content)
    {
        return $content
            ->title(__('Send Mail'))
            ->body(new MailForm());
    }
}
