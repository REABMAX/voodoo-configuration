<?php

namespace Voodoo\Configuration\Contracts;

/**
 * Interface ConfigurationResolverInterface
 * @package Voodoo\Configuration\Contracts
 */
interface ConfigurationResolverInterface
{
    /**
     * @param string $path
     * @param array $configuration
     * @return mixed
     */
    public function resolvePath(string $path, array $configuration);
}