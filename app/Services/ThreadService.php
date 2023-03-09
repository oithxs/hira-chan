<?php

namespace App\Services;

use App\Consts\Tables\ClubThreadConst;
use App\Consts\Tables\CollegeYearThreadConst;
use App\Consts\Tables\DepartmentThreadConst;
use App\Consts\Tables\JobHuntingThreadConst;
use App\Consts\Tables\LectureThreadConst;
use App\Models\ThreadModel;
use App\Repositories\HubRepository;
use App\Repositories\ThreadRepository;
use App\Services\TableService;

class ThreadService
{
    private TableService $tableService;

    public function __construct()
    {
        $this->tableService = new TableService();
    }

    /**
     * 大枠カテゴリ名から各テーブルの定数クラスの完全修飾クラス名を取得する
     *
     * @param string $threadPrimaryCategoryName 大枠カテゴリ名
     * @return string|null 大枠カテゴリ名に対応する各モデルの完全修飾クラス名
     */
    public function getTableConst(string $threadPrimaryCategoryName): string | null
    {
        switch ($threadPrimaryCategoryName) {
            case ClubThreadConst::PRIMARY_CATEGORY_NAME:
                return ClubThreadConst::class;
            case CollegeYearThreadConst::PRIMARY_CATEGORY_NAME:
                return CollegeYearThreadConst::class;
            case DepartmentThreadConst::PRIMARY_CATEGORY_NAME:
                return DepartmentThreadConst::class;
            case JobHuntingThreadConst::PRIMARY_CATEGORY_NAME:
                return JobHuntingThreadConst::class;
            case LectureThreadConst::PRIMARY_CATEGORY_NAME:
                return LectureThreadConst::class;
            default:
                return null;
        }
    }

    /**
     * 大枠カテゴリから，Eloquent モデルの完全修飾クラス名を取得する
     *
     * @param string $threadPrimaryCategoryName 大枠カテゴリ名
     * @return string 大枠カテゴリ名に対応する各モデルの完全修飾クラス名
     */
    public function getThreadClassName(string $threadPrimaryCategoryName): string
    {
        $tableConst = $this->getTableConst($threadPrimaryCategoryName);
        return $tableConst !== null ? $tableConst::MODEL_FQCN : '';
    }

    /**
     * 大枠カテゴリから，テーブル名を取得する
     *
     * @param string $threadPrimaryCategoryName 大枠カテゴリ名
     * @return string 大枠カテゴリ名に対応する各モデルのテーブル名
     */
    public function getTableName(string $threadPrimaryCategoryName): string
    {
        $tableConst = $this->getTableConst($threadPrimaryCategoryName);
        return $tableConst !== null ? $tableConst::NAME : '';
    }

    /**
     * スレッドIDから外部キー名を取得する
     *
     * @param string $threadId 外部キー名を取得したいスレッドID
     * @return string 外部キー名
     */
    public function threadIdToForeignKey(string $threadId): string
    {
        $threadPrimaryCategoryName = HubRepository::getThreadPrimaryCategoryName($threadId);
        return $this->tableService->makeForeignKeyName(
            $this->getTableName($threadPrimaryCategoryName)
        );
    }

    /**
     * スレッドIDからモデルクラスを取得する
     *
     * @param string $threadId モデルクラスを取得したいスレッドID
     * @return string モデルクラス名
     */
    public function threadIdToModel(string $threadId): string
    {
        return $this->getThreadClassName(
            HubRepository::getThreadPrimaryCategoryName($threadId)
        );
    }

    /**
     * スレッドへの書き込みから外部キー名を取得する
     *
     * @param ThreadModel $post スレッドへの書き込み
     * @return string 外部キー名
     */
    public function postToForeignKey(ThreadModel $post): string
    {
        return  $this->tableService->makeForeignKeyName($this->postToTableName($post));
    }

    /**
     * スレッドへの書き込みからテーブル名を取得する
     *
     * @param ThreadModel $post スレッドへの書き込み
     */
    public function postToTableName(ThreadModel $post): string
    {
        return $this->getTableName($this->postToThreadPrimaryCategoryName($post));
    }

    /**
     * スレッドへの書き込みから大枠カテゴリ名を取得する
     *
     * @param ThreadModel $post スレッドへの書き込み
     * @return string
     */
    public function postToThreadPrimaryCategoryName(ThreadModel $post): string
    {
        return ThreadRepository::postToThreadPrimaryCategoryName($post);
    }
}
