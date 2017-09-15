<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\CacheArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadAllComponentConfigsFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadAllComponentConfigs
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $readComponentRegistryServices = $config['zrcms-component-registry-readers'];

        return new ReadAllComponentConfigs(
            $serviceContainer,
            $readComponentRegistryServices,
            $serviceContainer->get(CacheArray::class)
        );
    }
}
