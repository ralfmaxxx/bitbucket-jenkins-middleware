<?php

declare(strict_types=1);

namespace Middleware\Bitbucket\Webhook\Push\Element;

final class Repository
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function contains(string $text) : bool
    {
        return mb_strpos($this->name, $text) !== false;
    }
}
