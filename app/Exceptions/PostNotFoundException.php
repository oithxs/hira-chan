<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class PostNotFoundException extends Exception
{
    public function __construct(string $message = "書き込みが存在しません", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
