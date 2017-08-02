<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api;

use Interop\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetConfigViewRenderDataGetterComponentsBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetConfigViewRenderDataGetterComponentsBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registryConfig = $config['zrcms']['view-render-data-getters'];

        return new GetConfigViewRenderDataGetterComponentsBasic(
            $registryConfig,
            $serviceContainer->get(ReadViewRenderDataGetterComponentConfig::class),
            $serviceContainer->get(Cache::class)
        );
    }
}
