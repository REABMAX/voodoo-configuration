<?php

namespace Voodoo\Configuration\Contracts;

/**
 * Interface ConfigurationManagerInterface
 * @package Voodoo\Configuration\Contracts
 */
interface ConfigurationManagerInterface
{
    /**
     * @param ConfigurationResolverInterface $configurationResolver
     * @return ConfigurationManagerInterface
     */
    public function withResolver(ConfigurationResolverInterface $configurationResolver): self;

    /**
     * @param string $map
     * @return mixed
     */
    public function get(string $map);

    /**
     * @param array $configuration
     * @return mixed
     */
    public function setAndLock(array $configuration);

    /**
     * @param array $configuration
     * @return ConfigurationManagerInterface
     */
    public function withConfiguration(array $configuration): self;
}