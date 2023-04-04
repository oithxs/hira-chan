<?php

namespace App\Http\Requests\Threads;

use App\Consts\Tables\ThreadSecondaryCategoryConst;
use App\Rules\MaxLineRule as max_line;
use App\Rules\TrimRule as trim;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * ユーザーがこの要求を行う権限があるかどうかを判断する．
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * リクエストに適用されるバリデーションルールを取得．
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $table = ThreadSecondaryCategoryConst::NAME;
        $column = ThreadSecondaryCategoryConst::ID;

        return [
            'secondaryCategoryId' => "required|integer|exists:{$table},{$column}",
            'threadName' => ['required', 'string', new trim(), 'max:255', new max_line(1)],
        ];
    }
}
