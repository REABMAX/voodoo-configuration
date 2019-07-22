<?php

namespace Voodoo\Configuration;

use Voodoo\Configuration\Contracts\ConfigurationManagerInterface;
use Voodoo\Configuration\Contracts\ConfigurationResolverInterface;
use Voodoo\Configuration\Exception\ConfigurationException;

/**
 * Class ConfigurationManager
 * @package Voodoo\Configuration
 */
class ConfigurationManager implements ConfigurationManagerInterface
{
    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * @var ConfigurationResolverInterface
     */
    protected $resolver;

    /**
     * @var bool
     */
    protected $locked = false;

    /**
     * ConfigurationManager constructor.
     * @param ConfigurationResolverInterface $resolver
     * @param array $configuration
     * @throws ConfigurationException
     */
    public function __construct(ConfigurationResolverInterface $resolver, array $configuration = [])
    {
        $this->resolver = $resolver;
        if ($configuration) {
            $this->setAndLock($configuration);
        }
    }

    /**
     * @param string $map
     * @return mixed
     */
    public function get(string $map)
    {
        return $this->resolver->resolvePath($map, $this->configuration);
    }

    /**
     * @param array $configuration
     * @return mixed|void
     * @throws ConfigurationException
     */
    public function setAndLock(array $configuration)
    {
        if ($this->locked) {
            throw new ConfigurationException("ConfigurationManager is locked due to immutability. Please use withConfiguration()");
        }

        $this->configuration = $configuration;
        $this->locked = true;
    }

    /**
     * @param ConfigurationResolverInterface $configurationResolver
     * @return ConfigurationManagerInterface
     */
    public function withResolver(ConfigurationResolverInterface $configurationResolver): ConfigurationManagerInterface
    {
        $manager = clone $this;
        $manager->resolver = $configurationResolver;
        return $manager;
    }

    /**
     * @param array $configuration
     * @return ConfigurationManagerInterface
     */
    public function withConfiguration(array $configuration): ConfigurationManagerInterface
    {
        $manager = clone $this;
        $manager->configuration = $configuration;
        return $manager;
    }
}