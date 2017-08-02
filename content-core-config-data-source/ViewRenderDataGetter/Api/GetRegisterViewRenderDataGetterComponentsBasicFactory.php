<?php

namespace Zrcms\ContentCoreConfigDataSource\ViewRenderDataGetter\Api;

use Interop\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterViewRenderDataGetterComponentsBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetRegisterViewRenderDataGetterComponentsBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registryConfig = $config['zrcms']['view-render-data-getters'];

        return new GetRegisterViewRenderDataGetterComponentsBasic(
            $registryConfig,
            $serviceContainer->get(ReadViewRenderDataGetterComponentConfig::class),
            $serviceContainer->get(Cache::class)
        );
    }
}
