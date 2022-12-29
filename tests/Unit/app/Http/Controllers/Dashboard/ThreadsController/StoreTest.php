<?php

namespace Tests\Unit\app\Http\Controllers\Dashboard\ThreadsController;

use App\Http\Controllers\Dashboard\ThreadsController;
use App\Models\ClubThread;
use App\Models\CollegeYearThread;
use App\Models\DepartmentThread;
use App\Models\Hub;
use App\Models\JobHuntingThread;
use App\Models\LectureThread;
use App\Models\ThreadImagePath;
use App\Models\ThreadPrimaryCategory;
use App\Models\User;
use ErrorException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image;
use Tests\UseFormRequestTestCase;

class StoreTest extends UseFormRequestTestCase
{
    use RefreshDatabase;

    /**
     * テストユーザ
     *
     * @var User
     */
    private User $user;

    /**
     * すべての大枠カテゴリのスレッド
     *
     * @var array
     */
    private array $threads;

    /**
     * テスト画像のパス・名前
     *
     * @var array
     */
    private array $images;

    /**
     * スレッドに書き込むメッセージID
     *
     * @var integer
     */
    private int $message_id;

    /**
     * スレッドに書き込むメッセージ
     *
     * @var string
     */
    private string $message;

    /**
     * ユーザをセットする
     *
     * テスト対象のスレッド（テーブル）名をセットする
     *
     * すべての大枠カテゴリの書き込みをセットする
     *
     * @return void
     */
    protected function setAny(): void
    {
        $this->user = User::factory()->create();
        $this->message_id = 1;
        $this->message = 'message';
        $this->images = [
            'bmp' => ['path' => './tests/storage/image/test.bmp', 'name' => 'test.bmp'],
            'static.gif' => ['path' => './tests/storage/image/test.static.gif', 'name' => 'test.static.gif'],
            'animation.gif' => ['path' => './tests/storage/image/test.animation.gif', 'name' => 'test.animation.gif'],
            'jpg' => ['path' => './tests/storage/image/test.jpg', 'name' => 'test.jpg'],
            'png' => ['path' => './tests/storage/image/test.png', 'name' => 'test.png'],
            'webp' => ['path' => './tests/storage/image/test.webp', 'name' => 'test.webp'],
        ];

        $this->threads = [
            'club_thread' => Hub::factory()->create([
                'thread_secondary_category_id' => ThreadPrimaryCategory::where('name', '=', '部活')
                    ->first()
                    ->thread_secondary_categorys()
                    ->first()
                    ->id,
            ]),
            'college_year_thread' => Hub::factory()->create([
                'thread_secondary_category_id' => ThreadPrimaryCategory::where('name', '=', '学年')
                    ->first()
                    ->thread_secondary_categorys()
                    ->first()
                    ->id
            ]),
            'department_thread' => Hub::factory()->create([
                'thread_secondary_category_id' => ThreadPrimaryCategory::where('name', '=', '学科')
                    ->first()
                    ->thread_secondary_categorys()
                    ->first()
                    ->id
            ]),
            'job_hunting_thread' => Hub::factory()->create([
                'thread_secondary_category_id' => ThreadPrimaryCategory::where('name', '=', '就職')
                    ->first()
                    ->thread_secondary_categorys()
                    ->first()
                    ->id
            ]),
            'lecture_thread' => Hub::factory()->create([
                'thread_secondary_category_id' => ThreadPrimaryCategory::where('name', '=', '授業')
                    ->first()
                    ->thread_secondary_categorys()
                    ->first()
                    ->id
            ]),
        ];
    }

    /**
     * テスト対象のメソッドを設定
     *
     * @return void
     */
    protected function setMethod(): void
    {
        $this->method = [
            new ThreadsController,
            'store'
        ];
    }

    /**
     * テスト対象のメソッドに渡す引数を設定
     *
     * @return void
     */
    protected function setArgument(): void
    {
        $this->args = new Request([
            'thread_id' => $this->threads['club_thread'],
            'message' => $this->message,
            'reply' => NULL,
        ]);

        $this->args->setUserResolver(function () {
            return $this->user;
        });
    }

    /**
     * スレッド書き込み実行後に各カテゴリのテーブルに保存されているデータ（key）の期待値を返却する
     *
     * @return array
     */
    private function getKeysExpected(): array
    {
        return [
            'id',
            'hub_id',
            'user_id',
            'message_id',
            'message',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * スレッド書き込み実行後に thread image path テーブルに保存されているデータ（key）の期待値を返却する
     *
     * @return array
     */
    private function getKeysThreadImagePathExpected(): array
    {
        return [
            'id',
            'club_thread_id',
            'college_year_thread_id',
            'department_thread_id',
            'job_hunting_thread_id',
            'lecture_thread_id',
            'user_id',
            'img_path',
            'img_size',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * スレッド書き込み実行後に各カテゴリのテーブルに保存されているデータ（value）の期待値を返却する
     *
     * @param \App\Models\Hub
     * @return array
     */
    private function getValuesExpected(Hub $thread): array
    {
        if ($thread->thread_secondary_category->thread_primary_category->name == "部活") {
            $thread_primary_category = 'club_thread';
        } else if ($thread->thread_secondary_category->thread_primary_category->name == "学年") {
            $thread_primary_category = 'college_year_thread';
        } else if ($thread->thread_secondary_category->thread_primary_category->name == "学科") {
            $thread_primary_category = 'department_thread';
        } else if ($thread->thread_secondary_category->thread_primary_category->name == "就職") {
            $thread_primary_category = 'job_hunting_thread';
        } else if ($thread->thread_secondary_category->thread_primary_category->name == "授業") {
            $thread_primary_category = 'lecture_thread';
        } else {
            return [];
        }

        return [
            'hub_id' => $this->threads[$thread_primary_category]->id . '',
            'user_id' => $this->user->id . '',
            'message_id' => $this->message_id++,
            'message' => $this->message,
        ];
    }

    /**
     * スレッド書き込み実行後に各カテゴリのテーブルに保存されているデータ（value）の期待値を返却する
     *
     * メッセージの特殊文字変換を行う場合
     *
     * @param \App\Models\Hub
     * @return array
     */
    private function getValuesSpecialMessageExpected(Hub $thread): array
    {
        $response = $this->getValuesExpected($thread);

        $special_character_set = array(
            "&" => "&amp;",
            "<" => "&lt;",
            ">" => "&gt;",
            " " => "&ensp;",
            "　" => "&emsp;",
            "\n" => "<br>",
            "\t" => "&ensp;&ensp;"
        );
        $message = $this->message;
        foreach ($special_character_set as $key => $value) {
            $message = str_replace($key, $value, $message);
        }

        $response['message'] = $message;
        return $response;
    }

    /**
     * スレッド書き込み実行後に各カテゴリのテーブルに保存されているデータ（value）の期待値を返却する
     *
     * メッセージに返信を行う場合
     *
     * @param \App\Models\Hub
     * @return array
     */
    private function getValuesReplyPostsExpected(Hub $thread, $reply): array
    {
        $response = $this->getValuesExpected($thread);

        $message = $this->message;
        $reply = '<a class="bg-info" href="#thread_message_id_' . str_replace('>>> ', '', $this->args['reply']) . '">' . $this->args['reply'] . '</a>';
        $message = $reply . '<br>' . $message;

        $response['message'] = $message;
        return $response;
    }

    /**
     * スレッド書き込み実行後に thread image path テーブルに保存されているデータ（value）の期待値を返却する
     *
     * @param \App\Models\ClubThread |
     *        \App\Models\CollegeYearThread |
     *        \App\Models\DepartmentThread |
     *        \App\Models\JboHuntingThread |
     *        \App\Models\LectureThread $post
     * @param array $img
     * @return array
     */
    private function getValuesThreadImagePathExpected($post, array $img): array
    {
        if ($post instanceof ClubThread) {
            $club_thread_id = $post->id;
        } else if ($post instanceof CollegeYearThread) {
            $college_year_thread_id = $post->id;
        } else if ($post instanceof DepartmentThread) {
            $department_thread_id = $post->id;
        } else if ($post instanceof JobHuntingThread) {
            $job_hunting_thread_id = $post->id;
        } else if ($post instanceof LectureThread) {
            $lecture_thread_id = $post->id;
        } else {
            return [];
        }

        return [
            'club_thread_id' => $club_thread_id ?? null,
            'college_year_thread_id' => $college_year_thread_id ?? null,
            'department_thread_id' => $department_thread_id ?? null,
            'job_hunting_thread_id' => $job_hunting_thread_id ?? null,
            'lecture_thread_id' => $lecture_thread_id ?? null,
            'user_id' => $this->user->id . '',
            'img_size' => Image::make(new UploadedFile($img['path'], $img['name']))->encode('jpg')->orientate()->filesize(),
        ];
    }

    /**
     * 渡された配列のうち，指定したインデックスの要素を返却する
     *
     * @param array $ary 連想配列
     * @param array $keys 連想配列のインデックスを指定
     * @return array インデックスと一致した連想配列を返却
     */
    private function getArrayElement(array $ary, array $keys): array
    {
        $response = [];
        foreach ($keys as $key) {
            $response[$key] = $ary[$key];
        }
        return $response;
    }

    /**
     * テスト対象メソッドに渡す引数に画像をセットする
     *
     * @param array $image
     * @return void
     */
    public function setArgumentWithImage(array $image): void
    {
        $this->args = new Request(
            query: [
                'thread_id' => $this->threads['club_thread'],
                'message' => $this->message,
                'reply' => NULL,
                'img' => 'undefined'
            ],
            files: [
                'img' => new UploadedFile($image['path'], $image['name'])
            ]
        );

        $this->args->setUserResolver(function () {
            return $this->user;
        });
    }

    /**
     * すべての大枠カテゴリにおいてスレッドに複数の書き込みを行う
     *
     * @return void
     */
    public function test_multiple_posts_in_a_thread_in_all_broad_categories(): void
    {
        foreach ($this->threads as $thread) {
            $this->message_id = 1;
            foreach (range(1, 5) as $_) {
                $this->useFormRequest(['thread_id'], [$thread->id]);
            }

            if ($thread->thread_secondary_category->thread_primary_category->name == "部活") {
                $posts = ClubThread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "学年") {
                $posts = CollegeYEarTHread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "学科") {
                $posts = DepartmentThread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "就職") {
                $posts = JobHuntingThread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "授業") {
                $posts = LectureThread::where('hub_id', '=', $thread->id)->get();
            }

            foreach ($posts as $post) {
                $this->assertSame($this->getKeysExpected(), array_keys($post->toArray()));
                $this->assertSame(
                    $this->getValuesExpected($thread),
                    $this->getArrayElement($post->toArray(), [
                        'hub_id',
                        'user_id',
                        'message_id',
                        'message',
                    ])
                );
            }
        }
    }

    /**
     * スレッドID未定義で書き込みを行う
     *
     * @return void
     */
    public function test_write_with_undefined_thread_id(): void
    {
        $thread_id = Str::random(0);
        $this->assertThrows(
            fn () => $this->useFormRequest(['thread_id'], [$thread_id]),
            ErrorException::class
        );
        $this->assertSame([], ClubThread::where('hub_id', '=', $thread_id)->get()->toArray());
        $this->assertSame([], CollegeYearThread::where('hub_id', '=', $thread_id)->get()->toArray());
        $this->assertSame([], DepartmentThread::where('hub_id', '=', $thread_id)->get()->toArray());
        $this->assertSame([], JobHuntingThread::where('hub_id', '=', $thread_id)->get()->toArray());
        $this->assertSame([], LectureThread::where('hub_id', '=', $thread_id)->get()->toArray());
    }

    /**
     * 存在しないスレッドに書き込みを行う
     *
     * @return void
     */
    public function test_make_a_post_in_a_thread_that_does_not_exist(): void
    {
        $thread_id = 'nonexistent thread id';
        $this->assertThrows(
            fn () => $this->useFormRequest(['thread_id'], [$thread_id]),
            ErrorException::class
        );
        $this->assertSame([], ClubThread::where('hub_id', '=', $thread_id)->get()->toArray());
        $this->assertSame([], CollegeYearThread::where('hub_id', '=', $thread_id)->get()->toArray());
        $this->assertSame([], DepartmentThread::where('hub_id', '=', $thread_id)->get()->toArray());
        $this->assertSame([], JobHuntingThread::where('hub_id', '=', $thread_id)->get()->toArray());
        $this->assertSame([], LectureThread::where('hub_id', '=', $thread_id)->get()->toArray());
    }

    /**
     * すべての大枠カテゴリにおいて，メッセージ未定義で書き込みを行う
     *
     * バリデーションをjsで行っているためここではエラーが出ない
     *
     * @todo https://github.com/oithxs/hira-chan/issues/176
     *
     * @return void
     */
    public function test_write_with_message_undefined_in_all_large_frame_categories(): void
    {
        $this->message = Str::random(0);

        foreach ($this->threads as $thread) {
            $this->message_id  = 1;
            $this->useFormRequest(['thread_id', 'message'], [$thread->id, $this->message]);

            if ($thread->thread_secondary_category->thread_primary_category->name == "部活") {
                $posts = ClubThread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "学年") {
                $posts = CollegeYEarTHread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "学科") {
                $posts = DepartmentThread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "就職") {
                $posts = JobHuntingThread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "授業") {
                $posts = LectureThread::where('hub_id', '=', $thread->id)->get();
            }

            foreach ($posts as $post) {
                $this->assertSame($this->getKeysExpected(), array_keys($post->toArray()));
                $this->assertSame(
                    $this->getValuesExpected($thread),
                    $this->getArrayElement($post->toArray(), [
                        'hub_id',
                        'user_id',
                        'message_id',
                        'message',
                    ])
                );
            }
        }
    }

    /**
     * すべての大枠カテゴリにおいて，メッセージの特殊文字変換が行われていることを確認する
     *
     * @return void
     */
    public function test_ensure_that_special_character_conversion_of_messages_is_performed_in_all_large_frame_categories(): void
    {
        $this->message = <<<EOF
<script>
	!"#$%&'()=~|`{+*}<>?_-^\@[;:],./\
&amp;
　\n
 \t
</script>
EOF;

        foreach ($this->threads as $thread) {
            $this->message_id  = 1;
            $this->useFormRequest(['thread_id', 'message'], [$thread->id, $this->message]);

            if ($thread->thread_secondary_category->thread_primary_category->name == "部活") {
                $posts = ClubThread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "学年") {
                $posts = CollegeYEarTHread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "学科") {
                $posts = DepartmentThread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "就職") {
                $posts = JobHuntingThread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "授業") {
                $posts = LectureThread::where('hub_id', '=', $thread->id)->get();
            }

            foreach ($posts as $post) {
                $this->assertSame($this->getKeysExpected(), array_keys($post->toArray()));
                $this->assertSame(
                    $this->getValuesSpecialMessageExpected($thread),
                    $this->getArrayElement($post->toArray(), [
                        'hub_id',
                        'user_id',
                        'message_id',
                        'message',
                    ])
                );
            }
        }
    }

    /**
     * すべての大枠カテゴリにおいてスレッドに複数の返信の書き込みを行う
     *
     * @return void
     */
    public function test_multiple_reply_posts_to_a_thread_in_all_broad_categories(): void
    {
        $reply = random_int(1, 5);
        foreach ($this->threads as $thread) {
            $this->message_id = 1;
            foreach (range(1, 5) as $_) {
                $this->useFormRequest(['thread_id', 'reply'], [$thread->id, $reply]);
            }

            if ($thread->thread_secondary_category->thread_primary_category->name == "部活") {
                $posts = ClubThread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "学年") {
                $posts = CollegeYEarTHread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "学科") {
                $posts = DepartmentThread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "就職") {
                $posts = JobHuntingThread::where('hub_id', '=', $thread->id)->get();
            } else if ($thread->thread_secondary_category->thread_primary_category->name == "授業") {
                $posts = LectureThread::where('hub_id', '=', $thread->id)->get();
            }

            foreach ($posts as $post) {
                $this->assertSame($this->getKeysExpected(), array_keys($post->toArray()));
                $this->assertSame(
                    $this->getValuesReplyPostsExpected($thread, $reply),
                    $this->getArrayElement($post->toArray(), [
                        'hub_id',
                        'user_id',
                        'message_id',
                        'message',
                    ])
                );
            }
        }
    }

    /**
     * すべての大枠カテゴリにおいて，スレッドにbmp形式でアップロードされた画像の書き込みを行う
     *
     * @return void
     */
    public function test_writing_of_images_uploaded_in_bmp_format_in_threads_in_all_broad_categories(): void
    {
        Storage::fake('local');

        foreach ($this->threads as $key => $value) {
            $this->message_id = 1;
            $this->setArgumentWithImage($this->images['bmp']);
            $this->useFormRequest(['thread_id'], [$value->id]);

            if ($value->thread_secondary_category->thread_primary_category->name == "部活") {
                $post = ClubThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "学年") {
                $post = CollegeYEarTHread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "学科") {
                $post = DepartmentThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "就職") {
                $post = JobHuntingThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "授業") {
                $post = LectureThread::where('hub_id', '=', $value->id)->first() ?? null;
            }

            $thread_image_path = ThreadImagePath::where($key . '_id', '=', $post->id)->first()->toArray();
            Storage::disk('local')->assertExists($thread_image_path['img_path']);
            $this->assertSame($this->getKeysExpected(), array_keys($post->toArray()));
            $this->assertSame($this->getKeysThreadImagePathExpected(), array_keys($thread_image_path));
            $this->assertSame(
                $this->getValuesExpected($value),
                $this->getArrayElement($post->toArray(), [
                    'hub_id',
                    'user_id',
                    'message_id',
                    'message',
                ])
            );
            $this->assertSame(
                $this->getValuesThreadImagePathExpected($post, $this->images['bmp']),
                $this->getArrayElement($thread_image_path, [
                    'club_thread_id',
                    'college_year_thread_id',
                    'department_thread_id',
                    'job_hunting_thread_id',
                    'lecture_thread_id',
                    'user_id',
                    'img_size',
                ])
            );
            $this->assertMatchesRegularExpression(
                '/^public\/images\/thread_message\/[0-9a-z]{32}\.jpg$/',
                $thread_image_path['img_path']
            );
        }
    }

    /**
     * すべての大枠カテゴリにおいて，スレッドにgif形式（アニメーションあり）でアップロードされた画像の書き込みを行う
     *
     * @return void
     */
    public function test_writing_of_images_uploaded_in_animation_gif_format_in_threads_in_all_broad_categories(): void
    {
        Storage::fake('local');

        foreach ($this->threads as $key => $value) {
            $this->message_id = 1;
            $this->setArgumentWithImage($this->images['animation.gif']);
            $this->useFormRequest(['thread_id'], [$value->id]);

            if ($value->thread_secondary_category->thread_primary_category->name == "部活") {
                $post = ClubThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "学年") {
                $post = CollegeYEarTHread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "学科") {
                $post = DepartmentThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "就職") {
                $post = JobHuntingThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "授業") {
                $post = LectureThread::where('hub_id', '=', $value->id)->first() ?? null;
            }

            $thread_image_path = ThreadImagePath::where($key . '_id', '=', $post->id)->first()->toArray();
            Storage::disk('local')->assertExists($thread_image_path['img_path']);
            $this->assertSame($this->getKeysExpected(), array_keys($post->toArray()));
            $this->assertSame($this->getKeysThreadImagePathExpected(), array_keys($thread_image_path));
            $this->assertSame(
                $this->getValuesExpected($value),
                $this->getArrayElement($post->toArray(), [
                    'hub_id',
                    'user_id',
                    'message_id',
                    'message',
                ])
            );
            $this->assertSame(
                $this->getValuesThreadImagePathExpected($post, $this->images['animation.gif']),
                $this->getArrayElement($thread_image_path, [
                    'club_thread_id',
                    'college_year_thread_id',
                    'department_thread_id',
                    'job_hunting_thread_id',
                    'lecture_thread_id',
                    'user_id',
                    'img_size',
                ])
            );
            $this->assertMatchesRegularExpression(
                '/^public\/images\/thread_message\/[0-9a-z]{32}\.jpg$/',
                $thread_image_path['img_path']
            );
        }
    }

    /**
     * すべての大枠カテゴリにおいて，スレッドにgif形式（アニメーションなし）でアップロードされた画像の書き込みを行う
     *
     * @return void
     */
    public function test_writing_of_images_uploaded_in_static_gif_format_in_threads_in_all_broad_categories(): void
    {
        Storage::fake('local');

        foreach ($this->threads as $key => $value) {
            $this->message_id = 1;
            $this->setArgumentWithImage($this->images['static.gif']);
            $this->useFormRequest(['thread_id'], [$value->id]);

            if ($value->thread_secondary_category->thread_primary_category->name == "部活") {
                $post = ClubThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "学年") {
                $post = CollegeYEarTHread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "学科") {
                $post = DepartmentThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "就職") {
                $post = JobHuntingThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "授業") {
                $post = LectureThread::where('hub_id', '=', $value->id)->first() ?? null;
            }

            $thread_image_path = ThreadImagePath::where($key . '_id', '=', $post->id)->first()->toArray();
            Storage::disk('local')->assertExists($thread_image_path['img_path']);
            $this->assertSame($this->getKeysExpected(), array_keys($post->toArray()));
            $this->assertSame($this->getKeysThreadImagePathExpected(), array_keys($thread_image_path));
            $this->assertSame(
                $this->getValuesExpected($value),
                $this->getArrayElement($post->toArray(), [
                    'hub_id',
                    'user_id',
                    'message_id',
                    'message',
                ])
            );
            $this->assertSame(
                $this->getValuesThreadImagePathExpected($post, $this->images['static.gif']),
                $this->getArrayElement($thread_image_path, [
                    'club_thread_id',
                    'college_year_thread_id',
                    'department_thread_id',
                    'job_hunting_thread_id',
                    'lecture_thread_id',
                    'user_id',
                    'img_size',
                ])
            );
            $this->assertMatchesRegularExpression(
                '/^public\/images\/thread_message\/[0-9a-z]{32}\.jpg$/',
                $thread_image_path['img_path']
            );
        }
    }

    /**
     * すべての大枠カテゴリにおいて，スレッドにjpg形式でアップロードされた画像の書き込みを行う
     *
     * @return void
     */
    public function test_writing_of_images_uploaded_in_jpg_format_in_threads_in_all_broad_categories(): void
    {
        Storage::fake('local');

        foreach ($this->threads as $key => $value) {
            $this->message_id = 1;
            $this->setArgumentWithImage($this->images['jpg']);
            $this->useFormRequest(['thread_id'], [$value->id]);

            if ($value->thread_secondary_category->thread_primary_category->name == "部活") {
                $post = ClubThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "学年") {
                $post = CollegeYEarTHread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "学科") {
                $post = DepartmentThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "就職") {
                $post = JobHuntingThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "授業") {
                $post = LectureThread::where('hub_id', '=', $value->id)->first() ?? null;
            }

            $thread_image_path = ThreadImagePath::where($key . '_id', '=', $post->id)->first()->toArray();
            Storage::disk('local')->assertExists($thread_image_path['img_path']);
            $this->assertSame($this->getKeysExpected(), array_keys($post->toArray()));
            $this->assertSame($this->getKeysThreadImagePathExpected(), array_keys($thread_image_path));
            $this->assertSame(
                $this->getValuesExpected($value),
                $this->getArrayElement($post->toArray(), [
                    'hub_id',
                    'user_id',
                    'message_id',
                    'message',
                ])
            );
            $this->assertSame(
                $this->getValuesThreadImagePathExpected($post, $this->images['jpg']),
                $this->getArrayElement($thread_image_path, [
                    'club_thread_id',
                    'college_year_thread_id',
                    'department_thread_id',
                    'job_hunting_thread_id',
                    'lecture_thread_id',
                    'user_id',
                    'img_size',
                ])
            );
            $this->assertMatchesRegularExpression(
                '/^public\/images\/thread_message\/[0-9a-z]{32}\.jpg$/',
                $thread_image_path['img_path']
            );
        }
    }

    /**
     * すべての大枠カテゴリにおいて，スレッドにpng形式でアップロードされた画像の書き込みを行う
     *
     * @return void
     */
    public function test_writing_of_images_uploaded_in_png_format_in_threads_in_all_broad_categories(): void
    {
        Storage::fake('local');

        foreach ($this->threads as $key => $value) {
            $this->message_id = 1;
            $this->setArgumentWithImage($this->images['png']);
            $this->useFormRequest(['thread_id'], [$value->id]);

            if ($value->thread_secondary_category->thread_primary_category->name == "部活") {
                $post = ClubThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "学年") {
                $post = CollegeYEarTHread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "学科") {
                $post = DepartmentThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "就職") {
                $post = JobHuntingThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "授業") {
                $post = LectureThread::where('hub_id', '=', $value->id)->first() ?? null;
            }

            $thread_image_path = ThreadImagePath::where($key . '_id', '=', $post->id)->first()->toArray();
            Storage::disk('local')->assertExists($thread_image_path['img_path']);
            $this->assertSame($this->getKeysExpected(), array_keys($post->toArray()));
            $this->assertSame($this->getKeysThreadImagePathExpected(), array_keys($thread_image_path));
            $this->assertSame(
                $this->getValuesExpected($value),
                $this->getArrayElement($post->toArray(), [
                    'hub_id',
                    'user_id',
                    'message_id',
                    'message',
                ])
            );
            $this->assertSame(
                $this->getValuesThreadImagePathExpected($post, $this->images['png']),
                $this->getArrayElement($thread_image_path, [
                    'club_thread_id',
                    'college_year_thread_id',
                    'department_thread_id',
                    'job_hunting_thread_id',
                    'lecture_thread_id',
                    'user_id',
                    'img_size',
                ])
            );
            $this->assertMatchesRegularExpression(
                '/^public\/images\/thread_message\/[0-9a-z]{32}\.jpg$/',
                $thread_image_path['img_path']
            );
        }
    }

    /**
     * すべての大枠カテゴリにおいて，スレッドにwebp形式でアップロードされた画像の書き込みを行う
     *
     * @return void
     */
    public function test_writing_of_images_uploaded_in_webp_format_in_threads_in_all_broad_categories(): void
    {
        Storage::fake('local');

        foreach ($this->threads as $key => $value) {
            $this->message_id = 1;
            $this->setArgumentWithImage($this->images['webp']);
            $this->assertThrows(
                fn () => $this->useFormRequest(['thread_id'], [$value->id]),
                NotReadableException::class
            );

            if ($value->thread_secondary_category->thread_primary_category->name == "部活") {
                $post = ClubThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "学年") {
                $post = CollegeYEarTHread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "学科") {
                $post = DepartmentThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "就職") {
                $post = JobHuntingThread::where('hub_id', '=', $value->id)->first() ?? null;
            } else if ($value->thread_secondary_category->thread_primary_category->name == "授業") {
                $post = LectureThread::where('hub_id', '=', $value->id)->first() ?? null;
            }

            Storage::disk('local')->assertDirectoryEmpty('public/images/thread_message');
            $this->assertSame($this->getKeysExpected(), array_keys($post->toArray()));
            $this->assertSame([], ThreadImagePath::where($key . '_id', '=', $post->id)->get()->toArray());
            $this->assertSame(
                $this->getValuesExpected($value),
                $this->getArrayElement($post->toArray(), [
                    'hub_id',
                    'user_id',
                    'message_id',
                    'message',
                ])
            );
        }
    }
}
