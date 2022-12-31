<?php

namespace Tests\Unit\app\Http\Controllers\Dashboard\ThreadImagePathController;

use App\Http\Controllers\Dashboard\ThreadImagePathController;
use App\Models\ClubThread;
use App\Models\CollegeYearThread;
use App\Models\DepartmentThread;
use App\Models\JobHuntingThread;
use App\Models\LectureThread;
use App\Models\ThreadImagePath;
use App\Models\User;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image;
use PHPUnit\Framework\Assert;
use Tests\UseFormRequestTestCase;

class StoreTest extends UseFormRequestTestCase
{
    use RefreshDatabase;

    /**
     * テストユーザ
     *
     * @var \App\Models\User
     */
    private User $user;

    /**
     * スレッドへ書き込み
     *
     * @var array
     */
    private array $posts;

    /**
     * テスト使用する画像パス一覧
     *
     * @var array
     */
    private array $images;

    /**
     * テスト対象のスレッド（テーブル）名
     *
     * @var string
     */
    private string $thread_primary_category;

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
        $this->thread_primary_category = 'club_thread';
        $this->images = [
            'bmp' => ['path' => './tests/storage/image/test.bmp', 'name' => 'test.bmp'],
            'static.gif' => ['path' => './tests/storage/image/test.static.gif', 'name' => 'test.static.gif'],
            'animation.gif' => ['path' => './tests/storage/image/test.animation.gif', 'name' => 'test.animation.gif'],
            'jpg' => ['path' => './tests/storage/image/test.jpg', 'name' => 'test.jpg'],
            'png' => ['path' => './tests/storage/image/test.png', 'name' => 'test.png'],
            'webp' => ['path' => './tests/storage/image/test.webp', 'name' => 'test.webp'],
        ];

        $this->posts = [
            'club_thread' => ClubThread::factory()->create(),
            'college_year_thread' => CollegeYearThread::factory()->create(),
            'department_thread' => DepartmentThread::factory()->create(),
            'job_hunting_thread' => JobHuntingThread::factory()->create(),
            'lecture_thread' => LectureThread::factory()->create(),
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
            new ThreadImagePathController,
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
        $this->args = [
            'img' => new UploadedFile($this->images['bmp']['path'], $this->images['bmp']['name']),
            'user_id' => $this->user->id,
            'thread_id' => $this->posts[$this->thread_primary_category]->hub_id,
            'message_id' => $this->posts[$this->thread_primary_category]->message_id,
            'thread_primary_category' => $this
                ->posts[$this->thread_primary_category]
                ->hub
                ->thread_secondary_category
                ->thread_primary_category
                ->name
        ];
    }

    /**
     * useFormRequestメソッドが実行されたときに最初に呼び出される．
     *
     * @return void
     */
    protected function setUpUseFormRequest(): void
    {
        $this->setArgument();
    }


    /**
     * テスト対象メソッドの引数を指定する
     *
     * @return mixed
     */
    protected function useMethod(): mixed
    {
        return ($this->method)(
            $this->args['img'],
            $this->args['user_id'],
            $this->args['thread_id'],
            $this->args['message_id'],
            $this->args['thread_primary_category']
        );
    }

    /**
     * スレッド作成テストで期待される返り値（key）を返却する
     *
     * @return array
     */
    private function getKeysExpected(): array
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
     * スレッド作成テストで期待される返り値（value）を取得する
     *
     * @param \App\Models\ClubThread |
     *        \App\Models\CollegeYearThread |
     *        \App\Models\DepartmentThread |
     *        \App\Models\JboHuntingThread |
     *        \App\Models\LectureThread $post
     * @param \Illuminate\Http\UploadedFile $img
     * @return array
     */
    private function getValuesExpected($post, UploadedFile $img): array
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
            'img_size' => Image::make($img)->encode('jpg')->orientate()->filesize(),
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
        $post = [];
        foreach ($keys as $key) {
            $post[$key] = $ary[$key];
        }
        return $post;
    }

    /**
     * すべての大枠カテゴリにおいて、bmp形式でアップロードされた画像を保存する
     *
     * @return void
     */
    public function test_save_uploaded_images_in_bmp_format_in_all_categories(): void
    {
        Storage::fake('local');

        foreach ($this->posts as $key => $value) {
            $this->thread_primary_category = $key;
            $img = new UploadedFile($this->images['bmp']['path'], $this->images['bmp']['name']);
            $this->useFormRequest(['img'], [$img]);
            $thread_image_path = ThreadImagePath::where($key . '_id', '=', $value->id)->first()->toArray();

            Storage::disk('local')->assertExists($thread_image_path['img_path']);
            $this->assertSame($this->getKeysExpected(), array_keys($thread_image_path));
            $this->assertSame(
                $this->getValuesExpected($value, $img),
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
     * すべての大枠カテゴリにおいて、git形式（アニメーションあり）でアップロードされた画像を保存する
     *
     * @return void
     */
    public function test_save_uploaded_images_in_animation_gif_format_in_all_categories(): void
    {
        Storage::fake('local');

        foreach ($this->posts as $key => $value) {
            $this->thread_primary_category = $key;
            $img = new UploadedFile($this->images['animation.gif']['path'], $this->images['animation.gif']['name']);
            $this->useFormRequest(['img'], [$img]);
            $thread_image_path = ThreadImagePath::where($key . '_id', '=', $value->id)->first()->toArray();

            Storage::disk('local')->assertExists($thread_image_path['img_path']);
            $this->assertSame($this->getKeysExpected(), array_keys($thread_image_path));
            $this->assertSame(
                $this->getValuesExpected($value, $img),
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
     * すべての大枠カテゴリにおいて、git形式（アニメーションなし）でアップロードされた画像を保存する
     *
     * @return void
     */
    public function test_save_uploaded_images_in_static_gif_format_in_all_categories(): void
    {
        Storage::fake('local');

        foreach ($this->posts as $key => $value) {
            $this->thread_primary_category = $key;
            $img = new UploadedFile($this->images['static.gif']['path'], $this->images['static.gif']['name']);
            $this->useFormRequest(['img'], [$img]);
            $thread_image_path = ThreadImagePath::where($key . '_id', '=', $value->id)->first()->toArray();

            Storage::disk('local')->assertExists($thread_image_path['img_path']);
            $this->assertSame($this->getKeysExpected(), array_keys($thread_image_path));
            $this->assertSame(
                $this->getValuesExpected($value, $img),
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
     * すべての大枠カテゴリにおいて、jpg形式でアプロードされた画像を保存する
     *
     * @return void
     */
    public function test_save_uploaded_images_in_jpg_format_in_all_categories(): void
    {
        Storage::fake('local');

        foreach ($this->posts as $key => $value) {
            $this->thread_primary_category = $key;
            $img = new UploadedFile($this->images['jpg']['path'], $this->images['jpg']['name']);
            $this->useFormRequest(['img'], [$img]);
            $thread_image_path = ThreadImagePath::where($key . '_id', '=', $value->id)->first()->toArray();

            Storage::disk('local')->assertExists($thread_image_path['img_path']);
            $this->assertSame($this->getKeysExpected(), array_keys($thread_image_path));
            $this->assertSame(
                $this->getValuesExpected($value, $img),
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
     * すべての大枠カテゴリにおいて、png形式でアップロードされた画像を保存する
     *
     * @return void
     */
    public function test_save_uploaded_images_in_png_format_in_all_categories(): void
    {
        Storage::fake('local');

        foreach ($this->posts as $key => $value) {
            $this->thread_primary_category = $key;
            $img = new UploadedFile($this->images['png']['path'], $this->images['png']['name']);
            $this->useFormRequest(['img'], [$img]);
            $thread_image_path = ThreadImagePath::where($key . '_id', '=', $value->id)->first()->toArray();

            Storage::disk('local')->assertExists($thread_image_path['img_path']);
            $this->assertSame($this->getKeysExpected(), array_keys($thread_image_path));
            $this->assertSame(
                $this->getValuesExpected($value, $img),
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
     * すべての大枠カテゴリにおいて、webp形式でアップロードされた画像を保存する
     *
     * @return void
     */
    public function test_save_uploaded_images_in_webp_format_in_all_categories(): void
    {
        Storage::fake('local');

        foreach ($this->posts as $key => $value) {
            $this->thread_primary_category = $key;
            $img = new UploadedFile($this->images['webp']['path'], $this->images['webp']['name']);
            $this->useFormRequest(['img'], [$img]);
            $thread_image_path = ThreadImagePath::where($key . '_id', '=', $value->id)->first()->toArray();

            Storage::disk('local')->assertExists($thread_image_path['img_path']);
            $this->assertSame($this->getKeysExpected(), array_keys($thread_image_path));
            $this->assertSame(
                $this->getValuesExpected($value, $img),
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
     * すべてのカテゴリにおいて、ファイルがアップロードされていない場合
     *
     * @return void
     */
    public function test_if_no_files_uploaded_in_all_categories(): void
    {
        Storage::fake('local');

        foreach ($this->posts as $key => $value) {
            $this->thread_primary_category = $key;
            $this->useFormRequest(['img'], [null]);
            Storage::disk('local')->assertDirectoryEmpty('public/images/thread_message');
            $this->assertSame([], ThreadImagePath::where($key . '_id', '=', $value->id)->get()->toArray());
        }
    }

    /**
     * すべてのカテゴリで存在しないユーザIDを引数とする
     *
     * @return void
     */
    public function test_user_id_not_present_in_all_categories_as_an_argument(): void
    {
        Storage::fake('local');

        foreach ($this->posts as $key => $value) {
            $this->thread_primary_category = $key;
            $this->assertThrows(
                fn () => $this->useFormRequest(['user_id'], ['non-existent user']),
                QueryException::class
            );
            Storage::disk('local')->assertDirectoryNotEmpty('public/images/thread_message');
        }
    }

    /**
     * すべてのカテゴリで存在しないスレッドIDを引数とする
     *
     * @return void
     */
    public function test_thread_id_not_present_in_all_categories_as_an_argument(): void
    {
        Storage::fake('local');

        foreach ($this->posts as $key => $value) {
            $this->thread_primary_category = $key;
            $this->assertThrows(
                fn () => $this->useFormRequest(['thread_id'], ['non-existent thread id']),
                ErrorException::class
            );
            Storage::disk('local')->assertDirectoryNotEmpty('public/images/thread_message');
        }
    }

    /**
     * すべてのカテゴリで存在しないメッセージIDを引数とする
     *
     * @return void
     */
    public function test_message_id_not_present_in_all_categories_as_an_argument(): void
    {
        Storage::fake('local');

        foreach ($this->posts as $key => $value) {
            $this->thread_primary_category = $key;
            $this->assertThrows(
                fn () => $this->useFormRequest(['message_id'], [0]),
                ErrorException::class
            );
            Storage::disk('local')->assertDirectoryNotEmpty('public/images/thread_message');
        }
    }

    /**
     * すべてのカテゴリで存在しない大枠カテゴリを引数とする
     *
     * @return void
     */
    public function test_thread_primary_category_not_present_in_all_categories_as_an_argument(): void
    {
        Storage::fake('local');

        foreach ($this->posts as $key => $value) {
            $this->thread_primary_category = $key;
            $this->useFormRequest(['thread_primary_category'], ['non-existent thread primary category']);
            Storage::disk('local')->assertDirectoryNotEmpty('public/images/thread_message');
        }
    }
}
