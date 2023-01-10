<?php

namespace Tests;

abstract class UseFormRequestTestCase extends TestCase
{
    /**
     * テスト対象のメソッド
     *
     * @var mixed
     */
    protected mixed $method;

    /**
     * テスト対象メソッドの引数
     *
     * @var mixed
     */
    protected mixed $args;

    public function setUp(): void
    {
        parent::setUp();
        $this->setAny();
        $this->setMethod();
        $this->setArgument();
    }

    /**
     * setUpメソッドが実行されたときに最初に呼び出される．
     *
     * @return void
     */
    protected function setAny(): void
    {
        //
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
     * useFormRequestメソッドが実行されたときに最初に呼び出される．
     *
     * @return void
     */
    protected function setUpUseFormRequest(): void
    {
        //
    }

    /**
     * テスト対象メソッドの引数を変更することが可能．
     *
     * @return mixed
     */
    protected function useMethod(): mixed
    {
        return ($this->method)($this->args);
    }

    /**
     * 対象メソッド実行時の引数を変更する．
     * このメソッドは，対象となるメソッドでエラーが発生したかどうかを返す．
     *
     * @param array $keys
     * @param array $values
     * @return mixed
     */
    protected function useFormRequest(array $keys = [], array $values = []): mixed
    {
        $this->setUpUseFormRequest();
        for ($i = 0; $i < count($keys); $i++) {
            $this->args[$keys[$i]] = $values[$i];
        }
        return $this->useMethod();
    }
}
