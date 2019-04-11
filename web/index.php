<?php

use GuzzleHttp\Client;
use Middleware\Bitbucket\Config\Configuration;
use Middleware\Bitbucket\Integration\Jenkins\Element\Commit as JenkinsCommit;
use Middleware\Bitbucket\Integration\Jenkins\Element\Url;
use Middleware\Bitbucket\Integration\Jenkins\Notifier;
use Middleware\Bitbucket\Webhook\Push\Analyzer as PushWebhookAnalyzer;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$symfonyRequest = Request::createFromGlobals();

$psrSevenFactory = new DiactorosFactory();

$psrRequest = $psrSevenFactory->createRequest($symfonyRequest);

$analyzer = new PushWebhookAnalyzer();
$configuration = new Configuration(__DIR__.'/../config/config.yml');
$notifier = new Notifier(new Client());

$push = $analyzer->analyze($psrRequest);

foreach ($configuration->get() as $integration) {
    if ($push->getRepository()->contains($integration['bitbucket']['repository_name'])) {
        $lastCommit = $push->getLastCommit();
        if (!is_null($lastCommit)) {
            $notifier->notify(
                new Url($integration['jenkins']['url_job_pattern'], new JenkinsCommit($integration['jenkins']['commit_parameter'], $pushCommit->getHash()))
            );
        }
    }
}
