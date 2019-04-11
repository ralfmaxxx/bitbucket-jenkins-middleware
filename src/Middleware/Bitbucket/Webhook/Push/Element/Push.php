<?php

declare(strict_types=1);

namespace Middleware\Bitbucket\Webhook\Push\Element;

final class Push
{
    private $repository;

    /**
     * @var Commit[]
     */
    private $commits;

    public function __construct(Repository $repository, array $commits)
    {
        $this->repository = $repository;
        $this->commits = $commits;
    }

    public function getRepository() : Repository
    {
        return $this->repository;
    }

    /**
     * @return Commit[]
     */
    public function getCommits() : array
    {
        return $this->commits;
    }

    public function getLastCommit() : ?Commit
    {
        return $this->commits[0] ?? null;
    }
}
