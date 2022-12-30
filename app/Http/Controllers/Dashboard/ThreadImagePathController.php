<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ClubThread;
use App\Models\CollegeYearThread;
use App\Models\DepartmentThread;
use App\Models\JobHuntingThread;
use App\Models\LectureThread;
use App\Models\ThreadImagePath;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ThreadImagePathController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * スレッドにアップロードされた画像を保存し，画像までのパスをDBに保存する．
     *
     * @see \App\Http\Controllers\Dashboard\ThreadsController::store() [Called]
     *
     * @param \Illuminate\Http\UploadedFile $img
     * @param string $user_id ユーザID
     * @param string $thread_id スレッド（Hub）ID
     * @param int $message_id メッセージID
     * @param string $thread_primary_category 大枠カテゴリ
     *
     * @return void
     */
    public function store(UploadedFile $img = null, string $user_id, string $thread_id, int $message_id, string $thread_primary_category)
    {
        if ($img) {
            $img = Image::make($img)->encode('jpg')->orientate();

            $size = $img->filesize();
            $path = 'public/images/thread_message/' . str_replace('-', '', Str::uuid()) . '.jpg';
            Storage::put($path, $img);

            if ($path) {
                switch ($thread_primary_category) {
                    case '部活':
                        ThreadImagePath::create([
                            'club_thread_id' => ClubThread::where('hub_id', '=', $thread_id)
                                ->where('message_id', '=', $message_id)
                                ->first()
                                ->id,
                            'user_id' => $user_id,
                            'img_path' => $path,
                            'img_size' => $size
                        ]);
                        break;
                    case '学年':
                        ThreadImagePath::create([
                            'college_year_thread_id' => CollegeYearThread::where('hub_id', '=', $thread_id)
                                ->where('message_id', '=', $message_id)
                                ->first()
                                ->id,
                            'user_id' => $user_id,
                            'img_path' => $path,
                            'img_size' => $size
                        ]);
                        break;
                    case '学科':
                        ThreadImagePath::create([
                            'department_thread_id' => DepartmentThread::where('hub_id', '=', $thread_id)
                                ->where('message_id', '=', $message_id)
                                ->first()
                                ->id,
                            'user_id' => $user_id,
                            'img_path' => $path,
                            'img_size' => $size
                        ]);
                        break;
                    case '就職':
                        ThreadImagePath::create([
                            'job_hunting_thread_id' => JobHuntingThread::where('hub_id', '=', $thread_id)
                                ->where('message_id', '=', $message_id)
                                ->first()
                                ->id,
                            'user_id' => $user_id,
                            'img_path' => $path,
                            'img_size' => $size
                        ]);
                        break;
                    case '授業':
                        ThreadImagePath::create([
                            'lecture_thread_id' => LectureThread::where('hub_id', '=', $thread_id)
                                ->where('message_id', '=', $message_id)
                                ->first()
                                ->id,
                            'user_id' => $user_id,
                            'img_path' => $path,
                            'img_size' => $size
                        ]);
                        break;
                }
            }

            $img->destroy();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThreadImagePath  $threadImagePaths
     * @return \Illuminate\Http\Response
     */
    public function show(ThreadImagePath $threadImagePaths)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThreadImagePath  $threadImagePaths
     * @return \Illuminate\Http\Response
     */
    public function edit(ThreadImagePath $threadImagePaths)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThreadImagePath  $threadImagePaths
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThreadImagePath $threadImagePaths)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThreadImagePath  $threadImagePaths
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThreadImagePath $threadImagePaths)
    {
        //
    }
}
