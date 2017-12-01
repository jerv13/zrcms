<?php

namespace Zrcms\Content\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentRegistryBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadComponentRegistryBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registry = $config['zrcms-components'];

        return new ReadComponentRegistryBasic(
            $registry,
            $serviceContainer->get(GetServiceFromAlias::class),
            'zrcms.component.config-reader',
            $serviceContainer->get(Cache::class)
        );
    }
}
