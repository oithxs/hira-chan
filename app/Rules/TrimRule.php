<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class TrimRule implements DataAwareRule, ValidationRule
{
    /**
     * バリデーション下の全データ
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    // ...

    /**
     * バリデーション下のデータをセット
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
    /**
     * バリデーションルールの実行
     *
     * @param string $attribute フィールドの名前
     * @param mixed $value フィールドの値
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->data[$attribute] = trim($this->data[$attribute]);
    }
}
