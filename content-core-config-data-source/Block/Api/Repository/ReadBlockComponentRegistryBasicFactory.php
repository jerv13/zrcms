<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api\Repository;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadBlockComponentRegistryBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadBlockComponentRegistryBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registry = $config['zrcms']['blocks'];

        return new ReadBlockComponentRegistryBasic(
            $registry,
            $serviceContainer->get(GetServiceFromAlias::class),
            $serviceContainer->get(Cache::class)
        );
    }
}
