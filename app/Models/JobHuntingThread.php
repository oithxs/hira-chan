<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobHuntingThread extends Model
{
    use HasFactory;
    use SerializeDate;

    /**
     * 接続するデータベース
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent.html
     * @see config/database.php
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * 関連付けるテーブル
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent.html
     *
     * @var string
     */
    protected $table = 'job_hunting_threads';

    /**
     * マスアサインメント可能な属性
     *
     * ここに登録している属性にはデータの挿入・更新が出来る．
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent.html
     *
     * @var string[]
     */
    protected $fillable = [
        'hub_id',
        'user_id',
        'message_id',
        'message',
    ];

    /**
     * シリアライズのために隠すべき属性
     *
     * ここに登録した属性は，管理画面で見ることが出来ない．
     * そのほかの効果は不明．
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-serialization.html
     * @todo 結局スレッドにアクセスする際のリンクにこの属性を使用しているので，隠す意味は無いかと思われる．
     *
     * @var array
     */
    protected $hidden = [
        'thread_id',
    ];

    /**
     * キャストすべき属性
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-serialization.html
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];


    /**
     * jobhunting thread に関連する thread image path を取得します．
     * 1：1
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function thread_image_path()
    {
        return $this->hasOne(ThreadImagePath::class);
    }

    /**
     * jobhunting thread に関連する like を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * job hunting thread を所有する hub を取得します．
     * 多：1
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function hub()
    {
        return $this->belongsTo(Hub::class);
    }

    /**
     * jobhunting thread を所有する user を取得します．
     * 多：1
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
