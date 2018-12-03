<?php

declare(strict_types=1);

namespace Middleware\Bitbucket\Integration\Jenkins\Element;

final class Commit
{
    private $parameterName;
    private $commitHash;

    public function __construct(string $parameterName, string $commitHash)
    {
        $this->parameterName = $parameterName;
        $this->commitHash = $commitHash;
    }

    public function getParameterName() : string
    {
        return $this->parameterName;
    }

    public function getCommitHash() : string
    {
        return $this->commitHash;
    }
}
