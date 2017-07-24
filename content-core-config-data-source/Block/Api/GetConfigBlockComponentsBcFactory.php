<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetConfigBlockComponentsBcFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetConfigBlockComponentsBc
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registryConfig = $config['zrcms']['blocks'];

        $registryConfigBc = $config['rcmPlugin'];

        return new GetConfigBlockComponentsBc(
            $registryConfig,
            $registryConfigBc,
            $serviceContainer->get(ReadBlockComponentConfig::class),
            $serviceContainer->get(Cache::class),
            $serviceContainer->get(PrepareBlockConfig::class)
        );
    }
}
