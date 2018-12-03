<?php

declare(strict_types=1);

namespace Middleware\Bitbucket\Config\Exception;

use Exception;
use RuntimeException;

final class ConfigurationException extends RuntimeException
{
    public static function fromPrevious(Exception $exception) : self
    {
        return new self($exception->getMessage(), $exception->getCode(), $exception);
    }
}
