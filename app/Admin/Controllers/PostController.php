<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __invoke(Request $request)
    {
        $count = 0;
        foreach (User::find($request->get('ids')) as $post) {
            $users[$count++] = array(
                "id" => $post->id
            );
        }
        return $users;
    }
}
