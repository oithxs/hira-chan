<?php

namespace Tests\Unit\app\Services\ThreadService;

use App\Consts\Tables\ClubThreadConst;
use App\Consts\Tables\CollegeYearThreadConst;
use App\Consts\Tables\DepartmentThreadConst;
use App\Consts\Tables\JobHuntingThreadConst;
use App\Consts\Tables\LectureThreadConst;
use App\Consts\Tables\ThreadsConst;
use App\Services\ThreadService;
use PHPUnit\Framework\TestCase;
use TypeError;

class GetTableConstTest extends TestCase
{
    private ThreadService $threadService;

    public function setUp(): void
    {
        $this->threadService = new ThreadService();
    }

    /**
     * 取得した各テーブルの定数クラスの完全修飾クラス名をアサートする
     *
     * @return void
     */
    public function testAssertsTheFqcnOfTheConstantClassForEachTableRetrieved(): void
    {
        foreach (ThreadsConst::CATEGORYS as $threadPrimaryCategoryName) {
            $response = $this->threadService->getTableConst($threadPrimaryCategoryName);
            switch ($threadPrimaryCategoryName) {
                case ClubThreadConst::PRIMARY_CATEGORY_NAME:
                    $this->assertSame(ClubThreadConst::class, $response);
                    break;
                case CollegeYearThreadConst::PRIMARY_CATEGORY_NAME:
                    $this->assertSame(CollegeYearThreadConst::class, $response);
                    break;
                case DepartmentThreadConst::PRIMARY_CATEGORY_NAME:
                    $this->assertSame(DepartmentThreadConst::class, $response);
                    break;
                case JobHuntingThreadConst::PRIMARY_CATEGORY_NAME:
                    $this->assertSame(JobHuntingThreadConst::class, $response);
                    break;
                case LectureThreadConst::PRIMARY_CATEGORY_NAME:
                    $this->assertSame(LectureThreadConst::class, $response);
                    break;
                default:
                    $this->assertSame(null, $response);
            }
        }
    }

    /**
     * 存在しない大枠カテゴリ名を引数とする
     *
     * @return void
     */
    public function testArgumentIsTheNameOfAThreadPrimaryCategoryNameThatDoesNotExist(): void
    {
        $threadPrimaryCategoryName = 'not existent thread primary category name';
        $response = $this->threadService->getTableConst($threadPrimaryCategoryName);
        $this->assertSame(null, $response);
    }

    /**
     * 大枠カテゴリ名未定義
     *
     * @return void
     */
    public function testThreadPrimaryCategoryNameUndefined(): void
    {
        $this->expectException(TypeError::class);
        $response = $this->threadService->getTableConst();
        $this->assertSame(null, $response);
    }
}
