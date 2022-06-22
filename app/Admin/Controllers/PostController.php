<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __invoke(Request $request)
    {
        $count = 1;
        session_start();
        foreach (User::find($request->get('ids')) as $post) {
            $_SESSION['email' . $count] = $post->email;
            $count++;
        }
    }
}
