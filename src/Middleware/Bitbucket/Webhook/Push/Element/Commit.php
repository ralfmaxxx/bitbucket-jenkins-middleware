<?php

declare(strict_types=1);

namespace Middleware\Bitbucket\Webhook\Push\Element;

final class Commit
{
    private $hash;

    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    public function getHash() : string
    {
        return $this->hash;
    }
}
