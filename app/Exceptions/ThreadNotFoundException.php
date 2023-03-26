<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ThreadNotFoundException extends Exception
{
    public function __construct(string $message = "スレッドが存在しません", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
