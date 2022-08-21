<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\MailForm;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;

class MailController extends Controller
{
    /**
     * Obtains the Email of the selected user.
     * Displays a form for entering the content of the emails to be sent to the users.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Encore\Admin\Layout\Content $content
     *
     * @return Encore\Admin\Layout\Content
     */

    public function show(Request $request, Content $content)
    {
        $emails = array();
        foreach (User::find(explode(',', $request->ids)) as $user) {
            array_push($emails, $user->email);
        }

        return $content
            ->title(__('Send Mail'))
            ->body(new MailForm($emails));
    }
}
