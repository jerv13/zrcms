<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api\Repository;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewLayoutTagsComponentRegistryBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadViewLayoutTagsComponentRegistryBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registry = $config['zrcms-components']['view-layout-tags'];

        return new ReadViewLayoutTagsComponentRegistryBasic(
            $registry,
            $serviceContainer->get(GetServiceFromAlias::class),
            $serviceContainer->get(Cache::class)
        );
    }
}
