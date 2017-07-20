<?php

namespace Zrcms\CoreConfigDataSource\Block\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlocksFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetBlocks
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('Config');

        $registryConfig = $config['zrcms']['blocks'];

        return new GetBlocks(
            $registryConfig,
            $serviceContainer->get(PrepareBlockConfig::class),
            $serviceContainer->get(Cache::class),
            $serviceContainer->get(ReadBlockConfig::class)
        );
    }
}
