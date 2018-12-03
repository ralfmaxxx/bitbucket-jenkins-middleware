<?php

declare(strict_types=1);

namespace spec\Middleware\Bitbucket\Webhook\Push;

use Middleware\Bitbucket\Webhook\Push\Analyzer;
use Middleware\Bitbucket\Webhook\Push\AnalyzerInterface;
use Middleware\Bitbucket\Webhook\Push\Element\Commit;
use Middleware\Bitbucket\Webhook\Push\Element\Push;
use Middleware\Bitbucket\Webhook\Push\Element\Repository;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

/**
 * @mixin Analyzer
 */
class AnalyzerSpec extends ObjectBehavior
{
    private const FIRST_HASH = 'we8qewiwehj';
    private const SECOND_HASH = 'ewqi9oewhkdhdk';
    private const THIRD_HASH = 'opew9oewmcsk';

    private const REPOSITORY_NAME = 'some/test';

    private const EMPTY_WEBHOOK_PAYLOAD = '{
        "push" : {
            "changes": []
        },
        "repository" : {
            "full_name" : "'.self::REPOSITORY_NAME.'"
        }
    }';

    private const WEBHOOK_PAYLOAD = '{
        "push" : {
            "changes": [
                {
                    "commits" : [
                        {
                            "hash" : "'.self::FIRST_HASH.'"
                        },
                        {
                            "hash" : "'.self::SECOND_HASH.'"
                        }
                    ]
                },
                {
                    "commits" : [
                        {
                            "hash" : "'.self::THIRD_HASH.'"
                        }
                    ]
                }
            ]
        },
        "repository" : {
            "full_name" : "'.self::REPOSITORY_NAME.'"
        }
    }';

    function it_is_initializable() : void
    {
        $this->shouldHaveType(Analyzer::class);
    }

    public function it_has_analyzer_interface() : void
    {
        $this->shouldBeAnInstanceOf(AnalyzerInterface::class);
    }

    public function it_returns_an_empty_list_of_commits_if_push_webook_does_not_contain_them(
        RequestInterface $request,
        StreamInterface $stream
    ) : void {

        $request
            ->getBody()
            ->willReturn($stream);

        $stream
            ->getContents()
            ->willReturn(self::EMPTY_WEBHOOK_PAYLOAD);

        $this
            ->analyze($request)
            ->shouldBeLike(
                new Push(
                    new Repository(self::REPOSITORY_NAME),
                    []
                )
            );
    }

    public function it_returns_a_list_of_commits_from_push_webhook(
        RequestInterface $request,
        StreamInterface $stream
    ) : void {

        $request
            ->getBody()
            ->willReturn($stream);

        $stream
            ->getContents()
            ->willReturn(self::WEBHOOK_PAYLOAD);

        $expectedCommits = [
            new Commit(self::FIRST_HASH),
            new Commit(self::SECOND_HASH),
            new Commit(self::THIRD_HASH),
        ];

        $this
            ->analyze($request)
            ->shouldBeLike(
                new Push(
                    new Repository(self::REPOSITORY_NAME),
                    $expectedCommits
                )
            );
    }
}
