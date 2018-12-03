<?php

declare(strict_types=1);

namespace Middleware\Bitbucket\Webhook\Push;

use Middleware\Bitbucket\Webhook\Push\Element\Commit;
use Middleware\Bitbucket\Webhook\Push\Element\Push;
use Middleware\Bitbucket\Webhook\Push\Element\Repository;
use Middleware\Bitbucket\Webhook\Push\Exception\AnalyzerException;
use Psr\Http\Message\RequestInterface;

final class Analyzer implements AnalyzerInterface
{
    private const MISSING_REPOSITORY_NAME = 'There is no information about repository name in this webhook payload: %s';

    public function analyze(RequestInterface $request) : Push
    {
        $commits = [];

        $requestBody = json_decode($request->getBody()->getContents(), true);

        foreach ($requestBody['push']['changes'] ?? [] as $change) {
            foreach ($change['commits'] ?? [] as $commit) {
                if ($hash = $commit['hash'] ?? '') {
                    $commits[] = new Commit($hash);
                }
            }
        }

        $repositoryName = $requestBody['repository']['full_name'] ?? '';

        if (!$repositoryName) {
            throw new AnalyzerException(
                sprintf(self::MISSING_REPOSITORY_NAME, $requestBody)
            );
        }

        return new Push(new Repository($repositoryName), $commits);
    }
}
