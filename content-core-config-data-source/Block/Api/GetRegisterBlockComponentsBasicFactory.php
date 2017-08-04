<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\Block\Api\ReadBlockComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetRegisterBlockComponentsBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetRegisterBlockComponentsBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registryConfig = $config['zrcms']['blocks'];

        return new GetRegisterBlockComponentsBasic(
            $registryConfig,
            $serviceContainer->get(ReadBlockComponentConfig::class),
            $serviceContainer->get(Cache::class)
        );
    }
}
