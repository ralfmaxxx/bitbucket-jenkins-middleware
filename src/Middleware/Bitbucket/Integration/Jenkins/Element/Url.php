<?php

declare(strict_types=1);

namespace Middleware\Bitbucket\Integration\Jenkins\Element;

final class Url
{
    private $urlPattern;
    private $commit;

    public function __construct(string $urlPattern, Commit $commit)
    {
        $this->urlPattern = $urlPattern;
        $this->commit = $commit;
    }

    public function get() : string
    {
        return str_replace($this->commit->getParameterName(), $this->commit->getCommitHash(), $this->urlPattern);
    }
}
