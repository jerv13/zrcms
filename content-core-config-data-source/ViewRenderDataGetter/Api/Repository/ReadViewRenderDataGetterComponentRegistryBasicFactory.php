<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api\Repository;

use Psr\Container\ContainerInterface;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadViewRenderDataGetterComponentRegistryBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadViewRenderDataGetterComponentRegistryBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registry = $config['zrcms']['view-render-data-getters'];

        return new ReadViewRenderDataGetterComponentRegistryBasic(
            $registry,
            $serviceContainer->get(GetServiceFromAlias::class)
        );
    }
}
