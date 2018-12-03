<?php

declare(strict_types=1);

namespace Middleware\Bitbucket\Webhook\Push;

use Middleware\Bitbucket\Webhook\Push\Element\Push;
use Middleware\Bitbucket\Webhook\Push\Exception\AnalyzerException;
use Psr\Http\Message\RequestInterface;

interface AnalyzerInterface
{
    /**
     * @throws AnalyzerException
     */
    public function analyze(RequestInterface $request) : Push;
}
