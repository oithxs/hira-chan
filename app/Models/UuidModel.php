<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UuidModel extends Model
{
    /**
     * モデルの主キー．
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * オートインクリメントIDのタイプを指定する．
     *
     * @var string
     */
    protected $keyType = 'char';

    /**
     * IDがオートインクリメントであるかどうかを示す．
     *
     * @var bool
     */
    public $incrementing = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->attributes['id'] = Str::uuid();
    }
}
