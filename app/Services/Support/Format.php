<?php

namespace App\Services\Support;

use Carbon\Carbon;

class Format
{
    /**
     * 日時をフォーマットする
     *
     * @param string $date 日時
     * @param string $format 日時フォーマット文字列
     * @return string フォーマット済み日時
     */
    public static function formatDate(string $date, string $format = 'Y-m-d H:i:s'): string
    {
        $jp_time = Carbon::parse($date)->setTimezone(config('app.timezone'));
        return $jp_time->format($format);
    }
}
