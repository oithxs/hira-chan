<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hub extends UuidModel
{
    use HasFactory;
    use SerializeDate;
    use SoftDeletes;

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
    protected $table = 'hub';

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
        'thread_secondary_category_id',
        'user_id',
        'name',
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
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * hub に関連する access log を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function access_logs()
    {
        return $this->hasMany(AccessLog::class);
    }

    /**
     * hub に関連する club thread を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function club_threads()
    {
        return $this->hasMany(ClubThread::class);
    }

    /**
     * hub に関連する college year thread を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function college_year_threads()
    {
        return $this->hasMany(CollegeYearThread::class);
    }

    /**
     * hub に関連する department thread を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function department_threads()
    {
        return $this->hasMany(DepartmentThread::class);
    }

    /**
     * hub に関連する job hunting thread を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function job_hunting_threads()
    {
        return $this->hasMany(JobHuntingThread::class);
    }

    /**
     * hub に関連する lecture thread を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function lecture_threads()
    {
        return $this->hasMany(LectureThread::class);
    }

    /**
     * hub を所有する thread secondary category を取得します．
     * 多：1
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function thread_secondary_category()
    {
        return $this->belongsTo(ThreadSecondaryCategory::class);
    }

    /**
     * hub を所有する user を取得します．
     * 多：1
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
