<?php

namespace Voodoo\Configuration;

use Voodoo\Configuration\Contracts\ConfigurationResolverInterface;
use Voodoo\Configuration\Exception\ConfigurationException;

/**
 * Class ArrowPathResolver
 * @package Voodoo\Configuration
 */
class ArrowPathResolver implements ConfigurationResolverInterface
{
    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * @param string $path
     * @param array $configuration
     * @return mixed|void
     */
    public function resolvePath(string $path, array $configuration)
    {
        $this->path = $path;
        $this->configuration = $configuration;

        $elements = explode(' > ', $path);
        return $this->resolve($elements, $configuration);
    }

    /**
     * @param array $elements
     * @param $configuration
     * @return mixed
     * @throws ConfigurationException
     */
    protected function resolve(array $elements, $configuration)
    {
        if (empty($elements) || !is_array($configuration)) {
            return $configuration;
        }

        $element = trim(array_shift($elements));
        if (!array_key_exists($element, $configuration)) {
            throw new ConfigurationException(sprintf("Could not find configuration path %s", $this->path));
        }

        $configuration = $configuration[$element];
        return $this->resolve($elements, $configuration);
    }
}