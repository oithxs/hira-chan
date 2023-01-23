<?php

namespace App\Consts;

use App\Consts\Tables\AccessLogConst;
use App\Consts\Tables\ClubThreadConst;
use App\Consts\Tables\CollegeYearThreadConst;
use App\Consts\Tables\ContactAdministratorConst;
use App\Consts\Tables\DepartmentThreadConst;
use App\Consts\Tables\FailedJobConst;
use App\Consts\Tables\HubConst;
use App\Consts\Tables\JobHuntingThreadConst;
use App\Consts\Tables\LectureThreadConst;
use App\Consts\Tables\LikeConst;
use App\Consts\Tables\MigrationConst;
use App\Consts\Tables\PasswordResetConst;
use App\Consts\Tables\PersonalAccessTokenConst;
use App\Consts\Tables\SessionConst;
use App\Consts\Tables\ThreadImagePathConst;
use App\Consts\Tables\ThreadPrimaryCategoryConst;
use App\Consts\Tables\ThreadSecondaryCategoryConst;
use App\Consts\Tables\UserConst;
use App\Consts\Tables\UserPageThemeConst;

class TableConst
{
    const NAMES = [
        AccessLogConst::NAME,
        ClubThreadConst::NAME,
        CollegeYearThreadConst::NAME,
        ContactAdministratorConst::NAME,
        DepartmentThreadConst::NAME,
        FailedJobConst::NAME,
        HubConst::NAME,
        JobHuntingThreadConst::NAME,
        LectureThreadConst::NAME,
        LikeConst::NAME,
        MigrationConst::NAME,
        PasswordResetConst::NAME,
        PersonalAccessTokenConst::NAME,
        SessionConst::NAME,
        ThreadImagePathConst::NAME,
        ThreadPrimaryCategoryConst::NAME,
        ThreadSecondaryCategoryConst::NAME,
        UserConst::NAME,
        UserPageThemeConst::NAME,
    ];

    const USED_FOREIGN_KEYS = [
        AccessLogConst::USED_FOREIGN_KEY,
        ClubThreadConst::USED_FOREIGN_KEY,
        CollegeYearThreadConst::USED_FOREIGN_KEY,
        ContactAdministratorConst::USED_FOREIGN_KEY,
        DepartmentThreadConst::USED_FOREIGN_KEY,
        FailedJobConst::USED_FOREIGN_KEY,
        HubConst::USED_FOREIGN_KEY,
        JobHuntingThreadConst::USED_FOREIGN_KEY,
        LectureThreadConst::USED_FOREIGN_KEY,
        LikeConst::USED_FOREIGN_KEY,
        MigrationConst::USED_FOREIGN_KEY,
        PasswordResetConst::USED_FOREIGN_KEY,
        PersonalAccessTokenConst::USED_FOREIGN_KEY,
        SessionConst::USED_FOREIGN_KEY,
        ThreadImagePathConst::USED_FOREIGN_KEY,
        ThreadPrimaryCategoryConst::USED_FOREIGN_KEY,
        ThreadSecondaryCategoryConst::USED_FOREIGN_KEY,
        UserConst::USED_FOREIGN_KEY,
        UserPageThemeConst::USED_FOREIGN_KEY,
    ];
}
