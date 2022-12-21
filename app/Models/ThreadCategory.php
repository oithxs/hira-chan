<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreadCategory extends Model
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
    protected $table = 'thread_categorys';

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
        'category_name',
        'category_type',
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
     * thread category に関連する hub を取得する．
     * 1：多
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function hub()
    {
        return $this->hasMany(Hub::class);
    }
}
