<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DepartmentThreads;
use App\Models\CollegeYearThreads;
use App\Models\ClubThreads;
use App\Models\LectureThreads;
use App\Models\JobHuntingThreads;
use App\Models\User;
use App\Models\Hub;
use App\Models\ThreadCategorys;
use App\Models\Likes;
use App\Models\ThreadImagePaths;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class jQuery_ajax extends Controller
{
    public $thread_id;
    public $user_email;

    public function send_Row(Request $request)
    {
        $special_character_set = array(
            "&" => "&amp;",
            "<" => "&lt;",
            ">" => "&gt;",
            " " => "&ensp;",
            "　" => "&emsp;",
            "\n" => "<br>",
            "\t" => "&ensp;&ensp;"
        );

        $message = $request->message;
        foreach ($special_character_set as $key => $value) {
            $message = str_replace($key, $value, $message);
        }

        if ($request->reply != null) {
            $reply = '<a class="bg-info" href="#thread_message_id_' . str_replace('>>> ', '', $request->reply) . '">' . $request->reply . '</a>';
            $message = $reply . '<br>' . $message;
        }

        $thread = Hub::where('thread_id', '=', $request->table)->first();
        $message_id = 0;

        switch ($thread->thread_category_type) {
            case '学科':
                $message_id = DepartmentThreads::where('thread_id', '=', $request->table)->max('message_id') + 1 ?? 0;
                DepartmentThreads::create([
                    'thread_id' => $request->table,
                    'message_id' => $message_id,
                    'user_name' => $request->user()->name,
                    'user_email' => $request->user()->email,
                    'message' => $message
                ]);
                break;

            case '学年':
                $message_id = CollegeYearThreads::where('thread_id', '=', $request->table)->max('message_id') + 1 ?? 0;
                CollegeYearThreads::create([
                    'thread_id' => $request->table,
                    'message_id' => $message_id,
                    'user_name' => $request->user()->name,
                    'user_email' => $request->user()->email,
                    'message' => $message
                ]);
                break;

            case '部活':
                $message_id = ClubThreads::where('thread_id', '=', $request->table)->max('message_id') + 1 ?? 0;
                ClubThreads::create([
                    'thread_id' => $request->table,
                    'message_id' => $message_id,
                    'user_name' => $request->user()->name,
                    'user_email' => $request->user()->email,
                    'message' => $message
                ]);
                break;

            case '授業':
                $message_id = LectureThreads::where('thread_id', '=', $request->table)->max('message_id') + 1 ?? 0;
                LectureThreads::create([
                    'thread_id' => $request->table,
                    'message_id' => $message_id,
                    'user_name' => $request->user()->name,
                    'user_email' => $request->user()->email,
                    'message' => $message
                ]);
                break;

            case '就職':
                $message_id = JobHuntingThreads::where('thread_id', '=', $request->table)->max('message_id') + 1 ?? 0;
                JobHuntingThreads::create([
                    'thread_id' => $request->table,
                    'message_id' => $message_id,
                    'user_name' => $request->user()->name,
                    'user_email' => $request->user()->email,
                    'message' => $message
                ]);
                break;

            default:
                break;
        }

        // 画像情報があれば，保存処理を実行
        if ($request->file('img')) {
            $img = Image::make($request->file('img'))->encode('jpg')->orientate()->save();

            $size = $img->filesize();
            $path = 'public/images/thread_message/' . str_replace('-', '', Str::uuid()) . '.jpg';
            Storage::put($path, $img);

            // store処理が実行出来ればDBにPathなどを保存
            if ($path) {
                ThreadImagePaths::create([
                    'thread_id' => $request->table,
                    'message_id' => $message_id,
                    'user_email' => $request->user()->email,
                    'img_path' => $path,
                    'img_size' => $size
                ]);
            }

            $img->destroy();
        }
    }

    public function create_thread(Request $request)
    {
        $uuid = str_replace('-', '', Str::uuid());

        $category = ThreadCategorys::where('category_name', '=', $request->thread_category)->first();

        Hub::create([
            'thread_id' => $uuid,
            'thread_name' => $request->table,
            'thread_category' => $request->thread_category,
            'thread_category_type' => $category->category_type,
            'user_email' => $request->user()->email
        ]);
    }

    public function like(Request $request)
    {
        Likes::insertOrIgnore([
            'thread_id' => $request->thread_id,
            'message_id' => $request->message_id,
            'user_email' => $request->user()->email,
            'created_at' => now(),
        ]);
    }

    public function unlike(Request $request)
    {
        Likes::where('thread_id', '=', $request->thread_id)
            ->where('message_id', '=', $request->message_id)
            ->where('user_email', '=', $request->user()->email)
            ->delete();
    }


    public function page_thema(Request $request)
    {
        $page_thema = $request->page_thema;
        $user = User::find($request->user()->id);
        $user->thema = $page_thema;
        $user->save();

        return null;
    }
}
