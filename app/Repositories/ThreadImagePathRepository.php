<?php

namespace App\Repositories;

use App\Models\ThreadImagePath;

class ThreadImagePathRepository
{
    /**
     * `thread_image_paths` テーブルのレコードを作成
     *
     * @param string $foreignKeyName 書き込んだテーブルの外部キー名
     * @param string $messageId 書き込みのメッセージID
     * @param string $userId 画像をアップロードしたユーザのID
     * @param string $imagePath 保存した画像までのパス
     * @param integer $fileSize 保存した画像のサイズ
     * @return void
     */
    public static function store(
        string $foreignKeyName,
        string $messageId,
        string $userId,
        string $imagePath,
        int $fileSize
    ): void {
        ThreadImagePath::create([
            $foreignKeyName => $messageId,
            'user_id' => $userId,
            'img_path' => $imagePath,
            'img_size' => $fileSize,
        ]);
    }
}
