<?php

namespace App\Repositories;

use App\Models\Hub;
use App\Models\ThreadPrimaryCategory;
use App\Models\ThreadSecondaryCategory;
use Illuminate\Database\Eloquent\Collection;

class HubRepository
{
    /**
     * スレッド一覧を取得する
     *
     * @return Collection スレッド一覧
     */
    public static function index(): Collection
    {
        return Hub::get();
    }

    /**
     * スレッドを作成する
     *
     * @param integer $threadSecondaryCategoryId スレッドが属する詳細カテゴリのID
     * @param string $userId スレッドを作成するユーザのID
     * @param string $name スレッド名
     * @return void
     */
    public static function store(
        int $threadSecondaryCategoryId,
        string $userId,
        string $name
    ): void {
        Hub::create([
            'thread_secondary_category_id' => $threadSecondaryCategoryId,
            'user_id' => $userId,
            'name' => $name,
        ]);
    }

    /**
     * id からスレッドを取得する
     *
     * @param string $threadId スレッドID
     * @return Hub|null スレッドIDに対応するスレッド
     */
    public static function find(string $threadId): Hub | null
    {
        return Hub::find($threadId);
    }

    /**
     * id から該当スレッドの詳細カテゴリを取得する
     *
     * @param string $threadId スレッドID
     * @return ThreadSecondaryCategory スレッドIDに対応する詳細カテゴリ
     */
    public static function getThreadSecondaryCategory(string $threadId): ThreadSecondaryCategory
    {
        return self::find($threadId)->thread_secondary_category;
    }

    /**
     * id から該当スレッドの大枠カテゴリを取得する
     *
     * @param string $threadId スレッドID
     * @return ThreadPrimaryCategory スレッドIDに対応する大枠カテゴリ
     */
    public static function getThreadPrimaryCategory(string $threadId): ThreadPrimaryCategory
    {
        return self::getThreadSecondaryCategory($threadId)->thread_primary_category;
    }

    /**
     * id から該当スレッドの大枠カテゴリの名前を取得する
     *
     * @param string $threadId スレッドID
     * @return string スレッドIDに対応する大枠カテゴリ名
     */
    public static function getThreadPrimaryCategoryName(string $threadId): string
    {
        return self::getThreadPrimaryCategory($threadId)->name;
    }
}
