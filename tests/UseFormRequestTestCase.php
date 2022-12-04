<?php

namespace Tests;

use Exception;

abstract class UseFormRequestTestCase extends TestCase
{
    /**
     * Methods to test.
     *
     * @var array
     */
    protected array $method;

    /**
     * Method Arguments to be Tested.
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
     * Set the target method in the child class.
     *
     * @return void
     */
    abstract protected function setMethod(): void;

    /**
     * Set the arguments of the target method in the child class.
     *
     * @return void
     */
    abstract protected function setArgument(): void;

    /**
     * Called first when the setUp method is executed
     *
     * @return void
     */
    protected function setAny(): void
    {
        // Can be defined in a child class
    }

    /**
     * Called first when the useFormRequest method is executed
     *
     * @return void
     */
    protected function reserve(): void
    {
        // Can be defined in a child class
    }

    /**
     * It is possible to change the arguments of the method under test.
     *
     * @return void
     */
    protected function useMethod(): void
    {
        ($this->method)($this->args);
    }

    /**
     * Changes the arguments when the target method is executed.
     * The method returns whether the target method can be executed or not.
     *
     * @param array $key
     * @param array $value
     * @return bool
     */
    protected function useFormRequest(array $keys, array $values): bool
    {
        $this->reserve();
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
