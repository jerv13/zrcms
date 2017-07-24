<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Cache\Service\Cache;
use Zrcms\ContentCore\Block\Model\BlockComponent;
use Zrcms\ContentCore\Block\Model\BlockComponentBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetConfigBlockComponentsBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetConfigBlockComponentsBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registryConfig = $config['zrcms']['blocks'];

        return new GetConfigBlockComponentsBasic(
            $registryConfig,
            $serviceContainer->get(ReadBlockComponentConfig::class),
            $serviceContainer->get(Cache::class)
        );
    }
}
