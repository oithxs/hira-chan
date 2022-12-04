<?php

namespace Tests;

use Exception;

abstract class UseFormRequestTestCase extends TestCase
{
    /**
     * テスト対象のメソッド
     *
     * @var array
     */
    protected array $method;

    /**
     * テスト対象メソッドの引数
     *
     * @var array
     */
    protected array $args;

    public function setUp(): void
    {
        parent::setUp();
        $this->setAny();
        $this->setMethod();
        $this->setArgument();
    }

    /**
     * 子クラスでテスト対象メソッドを設定します．
     *
     * @return void
     */
    abstract protected function setMethod(): void;

    /**
     * 子クラスでテスト対象メソッドの引数を設定します．
     *
     * @return void
     */
    abstract protected function setArgument(): void;

    /**
     * setUpメソッドが実行されたときに最初に呼び出される．
     *
     * @return void
     */
    protected function setAny(): void
    {
        // 子クラスで定義することが出来る．
    }

    /**
     * useFormRequestメソッドが実行されたときに最初に呼び出される．
     *
     * @return void
     */
    protected function setUpUseFormRequest(): void
    {
        // 子クラスで定義することが出来る．
    }

    /**
     * テスト対象メソッドの引数を変更することが可能．
     *
     * @return void
     */
    protected function useMethod(): void
    {
        ($this->method)($this->args);
    }

    /**
     * 対象メソッド実行時の引数を変更する．
     * このメソッドは，対象となるメソッドでエラーが発生したかどうかを返す．
     *
     * @param array $key
     * @param array $value
     * @return bool
     */
    protected function useFormRequest(array $keys, array $values): bool
    {
        $this->setUpUseFormRequest();
        for ($i = 0; $i < count($keys); $i++) {
            $this->args[$keys[$i]] = $values[$i];
        }
        try {
            $this->useMethod();
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}
