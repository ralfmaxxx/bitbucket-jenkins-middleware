<?php

declare(strict_types=1);

namespace Middleware\Bitbucket\Integration\Jenkins\Exception;

use Exception;
use RuntimeException;

final class NotifierException extends RuntimeException
{
    public static function fromPrevious(Exception $exception) : self
    {
        return new self($exception->getMessage(), $exception->getCode(), $exception);
    }
}
