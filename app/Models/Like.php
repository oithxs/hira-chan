<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
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
    protected $table = 'likes';

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
        'club_thread_id',
        'college_year_thread_id',
        'department_thread_id',
        'job_hunting_thread_id',
        'lecture_thread_id',
        'user_id'
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
        'update_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * like を所有する club thread を取得します．
     * 多：1
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function club_thread()
    {
        return $this->belongsTo(ClubThread::class);
    }

    /**
     * like を所有する college year thread を取得します．
     * 多：1
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function college_year_thread()
    {
        return $this->belongsTo(CollegeYearThread::class);
    }

    /**
     * like を所有する department thread を取得します．
     * 多：1
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function department_thread()
    {
        return $this->belongsTo(DepartmentThread::class);
    }

    /**
     * like を所有する job hunting thread を取得します．
     * 多：1
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function job_hunting_thread()
    {
        return $this->belongsTo(JobHuntingThread::class);
    }

    /**
     * like を所有する user thread を取得します．
     * 多：1
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
