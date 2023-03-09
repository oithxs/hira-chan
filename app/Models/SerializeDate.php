<?php

namespace App\Models;

use DateTimeInterface;

trait SerializeDate
{
    /**
     * 配列/JSONシリアライズ用の日付を用意する
     *
     * @link https://laravel.com/docs/9.x/eloquent-serialization
     *
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
