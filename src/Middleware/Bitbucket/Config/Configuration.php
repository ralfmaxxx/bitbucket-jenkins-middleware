<?php

declare(strict_types=1);

namespace Middleware\Bitbucket\Config;

use Middleware\Bitbucket\Config\Exception\ConfigurationException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

final class Configuration
{
    private $configuration;

    /**
     * @throws ConfigurationException
     */
    public function __construct(string $file)
    {
        try {
            $this->configuration = Yaml::parseFile($file);
        } catch (ParseException $exception) {
            throw ConfigurationException::fromPrevious($exception);
        }
    }

    public function get() : array
    {
        return $this->configuration['mapper'] ?? [];
    }
}
