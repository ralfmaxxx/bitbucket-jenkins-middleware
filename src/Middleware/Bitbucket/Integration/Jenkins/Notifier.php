<?php

declare(strict_types=1);

namespace Middleware\Bitbucket\Integration\Jenkins;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Middleware\Bitbucket\Integration\Jenkins\Element\Url;
use Middleware\Bitbucket\Integration\Jenkins\Exception\NotifierException;

final class Notifier implements NotifierInterface
{
    private const GET_METHOD = 'GET';

    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function notify(Url $url) : void
    {
        try {
            $this->client->send(new Request(self::GET_METHOD, $url->get()));
        } catch (GuzzleException $exception) {
            throw NotifierException::fromPrevious($exception);
        }
    }
}
