<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactAdministrator extends Model
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
    protected $table = 'contact_administrators';

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
        'contact_type_id',
        'user_id',
        'message',
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
     * contact_administrator を所有する contact_type を取得する
     * 多：1
     *
     * @return void
     */
    public function contact_type()
    {
        return $this->belongsTo(ContactType::class);
    }

    /**
     * contact administrator を所有する user を取得します．
     * 多：1
     *
     * @link https://readouble.com/laravel/9.x/ja/eloquent-relationships.html
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
