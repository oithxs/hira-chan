<?php

namespace App\Repositories;

use App\Models\ThreadImagePath;

class ThreadImagePathRepository
{
    /**
     * `thread_image_paths` テーブルのレコードを作成
     *
     * @param string $foreignKeyName
     * @param string $messageId
     * @param string $userId
     * @param string $imagePath
     * @param integer $fileSize
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
