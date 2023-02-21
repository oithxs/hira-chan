<?php

namespace Tests\Unit\app\Repositories\ContactTypeRepository;

use App\Consts\Tables\ContactTypeConst;
use App\Models\ContactType;
use App\Repositories\ContactTypeRepository;
use ErrorException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\MakeType;
use Tests\TestCase;
use TypeError;

class GetIdByNameTest extends TestCase
{
    use RefreshDatabase;

    /**
     * お問い合わせの種類IDからその名前を取得する
     *
     * @param integer $id お問い合わせの種類id
     * @return string お問い合わせの種類名
     */
    public function getContactTypeNameById(int $id): string
    {
        return ContactType::find($id)->name;
    }

    /**
     * お問い合わせの種類名からそのIDを取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatCanGetThatIdFromTheInquiryTypeName(): void
    {
        foreach (ContactTypeConst::CONTACT_TYPES as $contactType) {
            $contactTypeId = ContactTypeRepository::getIdByName($contactType);
            $this->assertSame(
                $contactType,
                $this->getContactTypeNameById($contactTypeId)
            );
        }
    }

    /**
     * 存在しないお問い合わせの種類名を引数とする
     *
     * @return void
     */
    public function testArgumentThatContactTypeNameThatDoesNotExists(): void
    {
        $contactTypeName = 'not existent contact type name';
        $this->assertThrows(
            fn () => ContactTypeRepository::getIdByName($contactTypeName),
            ErrorException::class
        );
    }

    /**
     * お問い合わせの種類名として様々な型を引数とする
     *
     * @return void
     */
    public function testVariousTypesOfArgumentsAsContactTypeNames(): void
    {
        foreach (MakeType::ignoreString() as $type) {
            $this->assertThrows(
                fn () => ContactTypeRepository::getIdByName($type),
                TypeError::class
            );
        }
    }
}
