<?php

namespace Zrcms\ContentCoreConfigDataSource\View\Api;

use Interop\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetConfigViewComponentsBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetConfigViewComponentsBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registryConfig = $config['zrcms']['views'];

        return new GetConfigViewComponentsBasic(
            $registryConfig,
            $serviceContainer->get(ReadViewComponentConfig::class),
            $serviceContainer->get(Cache::class)
        );
    }
}
