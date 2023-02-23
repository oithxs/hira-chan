<?php

namespace Tests\Unit\app\Http\Requests\Report;

use App\Consts\Tables\ContactTypeConst;
use App\Http\Requests\Report\FormContactAdministratorRequest;
use ErrorException;
use Illuminate\Support\Facades\Validator;
use stdClass;
use Tests\Support\Random;
use Tests\TestCase;

class FormContactAdministratorRequestTest extends TestCase
{
    const TYPE = 'radio_1';
    const TEXT = 'report_form_textarea';
    const TYPE_REQUIRED = 'どのような内容かを選択して下さい';
    const TYPE_EXISTS = '選択された値は有効ではありません';
    const TEXT_REQUIRED = '詳しい内容を入力して下さい';
    const TEXT_MAX = '15000文字以内で入力して下さい';

    /**
     * @dataProvider validationDataProvider
     * @param array $parameters
     * @param boolean $expected
     * @param array $messages
     * @return void
     */
    public function test(array $parameters, bool $expected, array $messages = ['', '']): void
    {
        $request = new FormContactAdministratorRequest();
        $validator = Validator::make($parameters, $request->rules(), $request->messages());
        $errorMessages = json_decode($validator->messages());

        $radio1ErrorMessage = $this->getRadio1ErrorMessage($errorMessages);
        $reportFormTextareaErrorMessage = $this->getReportFormTextareaErrorMessage($errorMessages);

        $this->assertSame($expected, $validator->passes());
        $this->assertSame($radio1ErrorMessage, $messages[0]);
        $this->assertSame($reportFormTextareaErrorMessage, $messages[1]);
    }

    /**
     * radio_1 に対するエラーメッセージを返却する
     * なければから文字を返却
     *
     * @param stdClass|array $errorMessages バリデータのからエラーメッセージをjson_decode
     * @return string radio_1 に対するエラーメッセージ
     */
    public function getRadio1ErrorMessage(stdClass | array $errorMessages): string
    {
        try {
            return $errorMessages->radio_1[0];
        } catch (ErrorException $e) {
            return '';
        }
    }

    /**
     * report_form_textarea に対するエラーメッセージを返却する
     * なければから文字を返却
     *
     * @param stdClass|array $errorMessages バリデータからのエラーメッセージをjson_decode
     * @return string report_form_textarea に対するエラーメッセージ
     */
    public function getReportFormTextareaErrorMessage(stdClass | array $errorMessages): string
    {
        try {
            return $errorMessages->report_form_textarea[0];
        } catch (ErrorException $e) {
            return '';
        }
    }

    /**
     * @return array
     */
    public function validationDataProvider(): array
    {
        return [
            ...$this->expectData(),
            ...$this->noData(),
            ...$this->noRadio1(),
            ...$this->existsRadio1(),
            ...$this->notExistsRadio1(),
            ...$this->noReportFormTextarea(),
            ...$this->maxReportFormTextarea(),
            ...$this->overReportFormTextarea(),
        ];
    }

    public function expectData(): array
    {
        return [
            '正しい入力' => [
                [
                    self::TYPE => ContactTypeConst::CONTACT_TYPES[0],
                    self::TEXT => Random::string(),
                ],
                true
            ],
        ];
    }

    /**
     * radio_1, report_form_textarea ともにデータなし
     *
     * @return array
     */
    public function noData(): array
    {
        return [
            'radio_1, report_form_textarea ともにデータなし' => [
                [], false, [self::TYPE_REQUIRED, self::TEXT_REQUIRED],
            ],
        ];
    }

    /**
     * radio_1 にデータなし
     *
     * @return array
     */
    public function noRadio1(): array
    {
        return [
            'radio_1 データなし' => [
                [self::TEXT => Random::string()], false, [self::TYPE_REQUIRED, ''],
            ],
        ];
    }

    /**
     * contact_types テーブルに存在するデータを radio_1 とする
     *
     * @return array
     */
    public function existsRadio1(): array
    {
        $response = [];
        foreach (ContactTypeConst::CONTACT_TYPES as $contactType) {
            $response["$contactType を radio_1 の値とする"] = [
                [self::TYPE => $contactType], false, ['', self::TEXT_REQUIRED],
            ];
        }
        return $response;
    }

    /**
     * contact_types テーブルに存在しないデータを radio_1 とする
     *
     * @return array
     */
    public function notExistsRadio1(): array
    {
        return [
            'contact_types テーブルに存在しないデータを radio_1 とする' => [
                [self::TYPE => 'not exists contact type name'], false, [self::TYPE_EXISTS, self::TEXT_REQUIRED],
            ],
        ];
    }

    /**
     * report_form_textarea にデータなし
     *
     * @return array
     */
    public function noReportFormTextarea(): array
    {
        return [
            'report_form_textarea にデータなし' => [
                [self::TYPE => ContactTypeConst::CONTACT_TYPES[0]], false, ['', self::TEXT_REQUIRED],
            ],
        ];
    }

    /**
     * report_form_textarea の最大文字数
     *
     * @return array
     */
    public function maxReportFormTextarea(): array
    {
        return [
            'report_form_textarea の最大文字数' => [
                [self::TEXT => Random::string(15000)], false, [self::TYPE_REQUIRED, '']
            ],
        ];
    }

    /**
     * report_form_textarea の文字数制限を超過
     *
     * @return array
     */
    public function overReportFormTextarea(): array
    {
        return [
            'report_form_textarea の文字数制限を超過' => [
                [self::TEXT => Random::string(15001)], false, [self::TYPE_REQUIRED, self::TEXT_MAX]
            ],
        ];
    }
}
