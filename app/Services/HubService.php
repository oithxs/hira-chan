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

class HubService
{
    /**
     * Eloquent モデルの完全修飾名
     *
     * @var string
     */
    private string $threadClassName;

    /**
     * テーブル名
     *
     * @var string
     */
    private string $tableName;

    public function __construct()
    {
        $this->threadClassName = '';
        $this->tableName = '';
    }

    /**
     * 大枠カテゴリから，Eloquent モデルの完全修飾クラス名を取得する
     *
     * @param string $threadPrimaryCategoryName
     * @return string
     */
    public function getThreadClassName(string $threadPrimaryCategoryName): string
    {
        switch ($threadPrimaryCategoryName) {
            case ClubThreadConst::PRIMARY_CATEGORY_NAME:
                $this->threadClassName = ClubThread::class;
                break;
            case CollegeYearThreadConst::PRIMARY_CATEGORY_NAME:
                $this->threadClassName = CollegeYearThread::class;
                break;
            case DepartmentThreadConst::PRIMARY_CATEGORY_NAME:
                $this->threadClassName = DepartmentThread::class;
                break;
            case JobHuntingThreadConst::PRIMARY_CATEGORY_NAME:
                $this->threadClassName = JobHuntingThread::class;
                break;
            case LectureThreadConst::PRIMARY_CATEGORY_NAME:
                $this->threadClassName = LectureThread::class;
        }
        return $this->threadClassName;
    }

    /**
     * 大枠カテゴリから，テーブル名を取得する
     *
     * @param string $threadPrimaryCategoryName
     * @return string
     */
    public function getTableName(string $threadPrimaryCategoryName): string
    {
        switch ($threadPrimaryCategoryName) {
            case ClubThreadConst::PRIMARY_CATEGORY_NAME:
                $this->tableName = ClubThreadConst::NAME;
                break;
            case CollegeYearThreadConst::PRIMARY_CATEGORY_NAME:
                $this->tableName = CollegeYearThreadConst::NAME;
                break;
            case DepartmentThreadConst::PRIMARY_CATEGORY_NAME:
                $this->tableName = DepartmentThreadConst::NAME;
                break;
            case JobHuntingThreadConst::PRIMARY_CATEGORY_NAME:
                $this->tableName = JobHuntingThreadConst::NAME;
                break;
            case LectureThreadConst::PRIMARY_CATEGORY_NAME:
                $this->tableName = LectureThreadConst::NAME;
        }
        return $this->tableName;
    }
}
