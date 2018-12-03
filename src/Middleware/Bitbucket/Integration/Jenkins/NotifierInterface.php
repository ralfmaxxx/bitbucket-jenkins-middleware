<?php namespace Middleware\Bitbucket\Integration\Jenkins;

use Middleware\Bitbucket\Integration\Jenkins\Element\Url;
use Middleware\Bitbucket\Integration\Jenkins\Exception\NotifierException;

interface NotifierInterface
{
    /**
     * @throws NotifierException
     */
    public function notify(Url $url) : void;
}
