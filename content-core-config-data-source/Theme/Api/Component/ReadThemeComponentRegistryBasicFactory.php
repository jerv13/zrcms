<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api\Component;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadThemeComponentRegistryBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadThemeComponentRegistryBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registry = $config['zrcms-components']['themes'];

        return new ReadThemeComponentRegistryBasic(
            $registry,
            $serviceContainer->get(GetServiceFromAlias::class),
            $serviceContainer->get(Cache::class)
        );
    }
}
