<?php

/*
 * This file is part of the GraphAware Neo4j Client package.
 *
 * (c) GraphAware Limited <http://graphaware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GraphAware\Neo4j\Client\HttpDriver;

use GraphAware\Common\Connection\BaseConfiguration;
use GraphAware\Common\Driver\ConfigInterface;
use GraphAware\Common\Driver\DriverInterface;
use Http\Discovery\HttpClientDiscovery;

class Driver implements DriverInterface
{
    const DEFAULT_HTTP_PORT = 7474;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param string            $uri
     * @param BaseConfiguration $config
     */
    public function __construct($uri, ConfigInterface $config = null)
    {
        if (null !== $config && !$config instanceof BaseConfiguration) {
            throw new \RuntimeException(sprintf('Second argument to "%s" must be null or "%s"', __CLASS__, BaseConfiguration::class));
        }

        $this->uri = $uri;
        $this->config = null !== $config ? $config : Configuration::create();
    }

    /**
     * @return Session
     */
    public function session()
    {
        return new Session($this->uri, HttpClientDiscovery::find(), $this->config);
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }
}
