<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaxLineRule implements ValidationRule
{
    protected $maxLine;

    public function __construct($maxLine)
    {
        $this->maxLine = $maxLine;
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
        if ($this->maxLine < (substr_count(trim($value), "\n") + 1)) {
            $fail("文字列は $this->maxLine 行以内である必要があります．");
        }
    }
}
