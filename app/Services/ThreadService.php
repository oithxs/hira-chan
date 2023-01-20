<?php

namespace App\Services;

use App\Consts\Tables\ClubThreadConst;
use App\Consts\Tables\CollegeYearThreadConst;
use App\Consts\Tables\DepartmentThreadConst;
use App\Consts\Tables\JobHuntingThreadConst;
use App\Consts\Tables\LectureThreadConst;
use App\Models\ClubThread;
use App\Models\CollegeYearThread;
use App\Models\DepartmentThread;
use App\Models\JobHuntingThread;
use App\Models\LectureThread;
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
     * @param string $threadPrimaryCategoryName
     * @return string|null
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
     * @param string $threadPrimaryCategoryName
     * @return string|null
     */
    public function getThreadClassName(string $threadPrimaryCategoryName): string
    {
        $tableConst = $this->getTableConst($threadPrimaryCategoryName);
        return $tableConst !== null ? $tableConst::MODEL_FQCN : '';
    }

    /**
     * 大枠カテゴリから，テーブル名を取得する
     *
     * @param string $threadPrimaryCategoryName
     * @return string|null
     */
    public function getTableName(string $threadPrimaryCategoryName): string
    {
        $tableConst = $this->getTableConst($threadPrimaryCategoryName);
        return $tableConst !== null ? $tableConst::NAME : '';
    }

    /**
     * スレッドへの書き込みから外部キー名を取得する
     *
     * @param ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread $post
     * @return string
     */
    public function postToForeignKey(
        ClubThread | CollegeYearThread | DepartmentThread | JobHuntingThread | LectureThread $post
    ): string {
        return  $this->tableService->makeForeignKeyName($this->postToTableName($post));
    }

    /**
     * スレッドへの書き込みからテーブル名を取得する
     *
     * @param ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread $post
     */
    public function postToTableName(
        ClubThread | CollegeYearThread | DepartmentThread | JobHuntingThread | LectureThread $post
    ): string {
        return $this->getTableName($this->postToThreadPrimaryCategoryName($post));
    }

    /**
     * スレッドへの書き込みから大枠カテゴリ名を取得する
     *
     * @param ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread $post
     * @return string
     */
    public function postToThreadPrimaryCategoryName(
        ClubThread | CollegeYearThread | DepartmentThread | JobHuntingThread | LectureThread $post
    ): string {
        return ThreadRepository::postToThreadPrimaryCategoryName($post);
    }
}